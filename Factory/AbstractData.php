<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

use WPObjects\Data\Data;

abstract class AbstractData extends AbstractModelFactory implements
    \WPObjects\Data\StorageInterface
{
    protected $id_key = 'id';
    
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
        $this->Data = new Data();
    }
    
    public function setStorage(\WPObjects\Data\Storage $Storage)
    {
        $this->Storage = $Storage;
    }
    
    public function getStorage()
    {
        return $this->Storage;
    }
    
    public function get($id = null, $filters = array(), $single = true)
    {
        $this->query(array_merge(array($this->id_key => $id), $filters));
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
        foreach ($this->getResult() as $Object) {

            $result[] = array(
                'label' => $Object->getName(),
                'value' => $Object->$this->id_key,
            );
            
        }

        return $result;
    }
    
    public function query($filters = array(), $result_as_object = false)
    {
        $this->filters = array_merge($this->getDefaultFilters(), $filters);
        $this->result_as_object = $result_as_object;
        $this->result = null;
        $this->result_data = array();
        
        $this->filter()
             ->sorting()
             ->initResults();
        
        return $this;
    }
    
    protected function getDefaultFilters()
    {
        return array(
            
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
        if (!isset($this->filters[$this->id_key]) || !is_array($this->filters[$this->id_key])) {
            return $this;
        }
        
        $result = array();
        foreach ($this->filters[$this->id_key] as $id) {
            foreach ($this->result_data as $data) {
                if ($data[$this->id_key] == $id) {
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
    
    /**
     * @return array
     */
    protected function pull()
    {
        if (is_null($this->pull)) {
            $this->pull = $this->getData()->getActiveDatas($this->getStorage());
        }
        
        return $this->pull;
    }
    
    /**
     * @return \WPObjects\Data\Data
     */
    public function getData()
    {
        return $this->Data;
    }
    
    /**
     * Return ids qualifiers types
     * @return array
     */
    protected function getQualifiersIds()
    {
        return $this->getModelType()->getQualifiersIds();
    }
    
    protected function getAgregatorsIds()
    {
        return $this->getModelType()->getAgregatorsIds();
    }
}