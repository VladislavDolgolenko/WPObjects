<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
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
     * @var boolean
     */
    protected $result_as_object = false;
    
    /**
     * Query filters, using for build query 
     * @var type 
     */
    protected $filters = array();
    
    /**
     * Last query results as initialized objects 
     * @var array
     */
    protected $result = null;
    
    /**
     * Identity attribute name
     * @var string
     */
    protected $id_key = 'id';
    
    abstract public function initModel($post);
    
    public function getIdAttrName()
    {
        return $this->id_key;
    }
    
    public function getResultIds()
    {
        $result_ids = array();
        foreach ($this->getResult() as $Model) {
            $result_ids[] = $Model->getId();
        }
        
        return $result_ids;
    }
    
    /**
     * Return last query result
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }
    
    /**
     * Insert last query result
     * @param array $result
     * @return $this
     */
    protected function setResult($result)
    {
        $this->result = $result;
        
        return $this;
    }
    
    public function getFilters()
    {
        return $this->filters;
    }
    
    public function updateFilters($array)
    {
        $this->filters = array_merge($this->filters, $array);
        
        return $this;
    }
    
    protected function setFilters($array, $silent = false)
    {
        $this->filters = $array;
        
        if ($silent !== true) {
            $this->trigger('set_query_filters');
        }
        
        return $this;
    }
    
    /**
     * Create value as array if string delimiter is ','
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