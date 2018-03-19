<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

namespace WPObjects\Factory;

use WPObjects\EventManager\Manager as EventManager;

abstract class AbstractModelFactory extends EventManager implements 
    FactoryInterface,
    AutocompeleInterface,
    \WPObjects\Service\ManagerInterface
{
    /**
     * @var \WPObjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    /**
     * Query flag. How to create result object. If true, result must be instance of \WP_Query
     * 
     * @var boolean
     */
    protected $result_as_object = false;
    
    /**
     * Query filters, using for build query 
     * 
     * @var type 
     */
    protected $filters = array();
    
    /**
     * Last query results as initialized objects 
     * 
     * @var array
     */
    protected $result = null;
    
    /**
     * Identity attribute name
     * 
     * @var string
     */
    protected $id_key = 'id';
    
    /**
     * Cached query results
     * 
     * @var array
     */
    protected $cache = array();
    
    /**
     * Total objects count from last query,
     * actual with pagination
     * sending in REST response as HTTP header X-Total-Count
     * 
     * @var int
     */
    protected $total_count = null;
    
    /**
     * Initialize model type
     * 
     * @param array|\WP_Post $post once result query data for initialize model
     * @return \WPObjects\Model\AbstractModel
     */
    abstract public function initModel($post);
    
    /**
     * Query processing
     */
    abstract protected function doQuery($filters = array(), $result_as_object = false);
    
    /**
     * Cache query control
     * 
     * @param array $filters
     * @param boolean $result_as_object
     * @return $this
     */
    public function query($filters = array(), $result_as_object = false)
    {
        $cache_hash_data = array_merge($filters, array('result_as_object' => $result_as_object));
        $cache_hash = serialize($cache_hash_data);
        $cache_id = hash('md5', $cache_hash); 
        if (isset($this->cache[$cache_id])) {
            $this->setResult($this->cache[$cache_id]);
            //\WPObjects\Log\Loger::getInstance()->write("Factory " . get_class($this) . " : query restore from cache with id $cache_id");
        } else {
            $this->doQuery($filters, $result_as_object);
            $this->cache[$cache_id] = $this->getResult();
        }
        
        return $this;
    }
    
    /**
     * Return identities attribute name of current factory model type 
     * 
     * @return string
     */
    public function getIdAttrName()
    {
        return $this->id_key;
    }
    
    /**
     * Return identities of objects from last result
     * 
     * @return array
     */
    public function getResultIds()
    {
        $result_ids = array();
        foreach ($this->getResult() as $Model) {
            $result_ids[] = $Model->getId();
        }
        
        return $result_ids;
    }
    
    public function getNamesAsString($max_length = 10)
    {
        $Results = $this->getResult();
        
        $string = '';
        foreach ($Results as $index => $model) {
            $string .= $model->getName();
            $string .= $index === count($Results) - 1 ? '.' : ', ';
            
            if ($index + 1 >= $max_length) {
                $string .= ' and more...';
                break;
            }
        }
        
        return $string;
    }
    
    /**
     * Return models from last query result
     * 
     * @return \WPObjects\Model\AbstractModel
     */
    public function getOneResult()
    {
        $Result = $this->getResult();
        
        return current($Result) ? current($Result) : null;
    }
    
    /**
     * Return last query result
     * 
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Insert last query result
     * 
     * @param array $result
     * @return $this
     */
    protected function setResult($result)
    {
        $this->result = $result;
        
        return $this;
    }
    
    /**
     * Return query filters
     * 
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
    
    /**
     * Merge current with new filters
     * 
     * @param array $array new filters
     * @return $this
     */
    public function updateFilters($array)
    {
        $this->filters = array_merge($this->filters, $array);
        
        return $this;
    }
    
    /**
     * Set current query filters.
     * 
     * @param array $array
     * @param bollean $silent if true initialize event 'set_query_filters'
     * @return $this
     */
    protected function setFilters($array, $silent = false)
    {
        $this->filters = $array;
        
        if ($silent !== true) {
            $this->trigger('set_query_filters');
        }
        
        return $this;
    }
    
    public function getSpecialSortingTypesForVCAddons()
    {
        return array();
    }
    
    public function getSpecialQueryParamsForVCAddons()
    {
        return array();
    }
    
    public function setTotalCount($int)
    {
        $this->total_count = (int)$int;
        
        return $this;
    }
    
    public function getTotalCount()
    {
        return $this->total_count;
    }
    
    /**
     * Reset query cache
     * 
     * @return $this
     */
    public function resetCache()
    {
        $this->cache = array();
        
        return $this;
    }
    
    /**
     * Create value as array if string delimiter is ','
     * 
     * @param string $string
     * @return array()
     */
    static public function prepareStringToArray($string)
    {
        if (is_array($string)) {
            return $string;
        }

        $values = explode(', ', $string);
        if (is_array($values) && count($values) !== 0) {
            return $values;
        }

        return array();
    }
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
        
        return $this;
    }
    
    public function getServiceManager()
    {
        if (is_null($this->ServiceManager)) {
            throw new \Exception('Undefined service manager');
        }
        
        return $this->ServiceManager;
    }
}