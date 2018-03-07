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

abstract class AbstractData extends AbstractModelFactory implements
    \WPObjects\Data\StorageInterface
{
    /**
     * Data access object
     * @var \WPObjects\Data\Data
     */
    protected $Data = null;
    
    /**
     * Storage object for forward data access object
     * @var \WPObjects\Data\Storage
     */
    protected $Storage = null;
    
    /**
     * All active data from Storage via data access object
     * @var array
     */
    protected $pull = null;
    
    /**
     * Last query results as source data arrays
     * @var array
     */
    protected $result_data = null;
    
    /**
     * Initialize data access object
     */
    public function __construct()
    {
        
    }
    
    public function setStorage(\WPObjects\Data\AbstractStorage $Storage)
    {
        $this->Storage = $Storage;
    }
    
    public function getStorage()
    {
        return $this->Storage;
    }
    
    public function get($id = null, $filters = array(), $single = true)
    {
        $this->query(array_merge(array($this->getIdAttrName() => $id), $filters));
        if ($single) {
            return current($this->getResult());
        } else {
            return $this->getResult();
        }
    }
    
    /**
     * Return array with compatible elements for autocompele selector in Visual Composer Addons.
     * @return array
     */
    function getForVCAutocompele()
    {
        /* @var $Object WPObjects\Model\AbstractModel */
        
        $result = array();
        $id_attr = $this->getIdAttrName();
        foreach ($this->getResult() as $Object) {

            $result[] = array(
                'label' => $Object->getName(),
                'value' => $Object->$id_attr,
            );
            
        }

        return $result;
    }
    
    /**
     * Return array with values for form select element
     * 
     * @return array
     */
    function getForSelect()
    {
        $result = array();
        
        foreach ($this->getResult() as $Object) {
            $result[$Object->getName()] = $Object->getId();
        }
        
        return $result;
    }
    
    public function doQuery($filters = array(), $result_as_object = false)
    {
        $filters = array_merge($this->getDefaultFilters(), $filters);
        $this->setFilters(array_filter($filters, array($this, 'orepareFilterValue')));
        $this->result_as_object = $result_as_object;
        $this->setResult(null);
        $this->result_data = array();
        
        $this->filter()
             ->sorting()
             ->initResults();
        
        return $this;
    }
    
    public function orepareFilterValue($var)
    {
        if ($var !== false && !(bool)$var) {
            return false;
        }
        
        return true;
    }
    
    protected function getDefaultFilters()
    {
        return array(
            'active' => true
        );
    }
    
    protected function filter()
    {
        $data = $this->pull();
        $result = array();
        foreach ($data as $model) {
            $confirm = true;
            foreach ($this->filters as $name => $value) {
                if (!isset($model[$name])) {
                    $confirm = false;
                }
                
                if ($confirm === false) {
                    break;
                }
                
                $model_value = $model[$name];
                if (is_array($model_value)) {
                    $confirm = $this->filterArray($model_value, $value);
                } else {
                    $confirm = $this->filterValue($model_value, $value);
                }
            }
            
            if ($confirm === true) {
                $result[] = $model;
            }
        }
        
        $this->result_data = $result;
        
        return $this;
    }
    
        protected function filterArray($model_array_values, $value)
        {
            foreach ($model_array_values as $model_value) {
                if ($this->filterValue($model_value, $value) === true) {
                    return true;
                }
            }
            
            return false;
        }
        
        protected function filterValue($model_value, $value)
        {
            if (!is_array($value) && $model_value != $value){
                return false;
            } else if (is_array($value) && !in_array($model_value, $value)) {
                return false;
            }
            
            return true;
        }
    
    protected function sorting()
    {
        $id_attr = $this->getIdAttrName();
        if (!isset($this->filters[$id_attr]) || !is_array($this->filters[$id_attr])) {
            return $this;
        }
        
        $result = array();
        foreach ($this->filters[$id_attr] as $id) {
            foreach ($this->result_data as $data) {
                if ($data[$id_attr] == $id) {
                    $result[] = $data;
                }
            }
        }
        
        $this->result_data = $result;
        
        return $this;
    }
    
    protected function initResults()
    {
        $result_models = array();
        foreach ($this->result_data as $data) {
            $result_models[] = $this->initModel($data);
        }
        
        $this->setResult($result_models);
        return $this;
    }
    
    public function resetCache()
    {
        parent::resetCache();
        $this->pull = null;
        
        return $this;
    }
    
    /**
     * @return array
     */
    public function pull()
    {
        if (is_null($this->pull) && $this->getData()) {
            $this->pull = $this->getData()->getDatas($this->getStorage());
        }
        
        return $this->pull;
    }
    
    /**
     * Return DataAccess Objects
     * 
     * @return \WPObjects\Data\Data
     */
    public function getData()
    {
        return $this->Data;
    }
    
    /**
     * @param \WPObjects\Data\Data $Data instance of data access 
     * @return $this
     */
    public function setData(\WPObjects\Data\Data $Data)
    {
        $this->Data = $Data;
        
        return $this;
    }
    
}