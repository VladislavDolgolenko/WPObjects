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

abstract class AbstractDataFactory extends AbstractFactory
{
    /**
     * @var \WPObjects\Data\Data
     */
    protected $Data = null;
    
    protected $pull = null;
    
    protected $filters = null;
    
    protected $result_data = null;
    
    public function __construct()
    {
        $this->Data = new Data();
    }
    
    public function query($filters = array(), $result_as_object = false)
    {
        $this->filters = $filters;
        $this->result_as_object = $result_as_object;
        $this->result = null;
        $this->result_data = array();
        
        $this->filter()
             ->sorting()
             ->initResults();
        
        return $this;
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
                } else if (!is_array($value) && $model[$name] != $value){
                    $confirm = false;
                } else if (is_array($value) && !in_array($model[$name], $value)) {
                    $confirm = false;
                }
            }
            
            if ($confirm === true) {
                $result[] = $model;
            }
        }
        
        $this->result_data = $result;
        
        return $this;
    }
    
    protected function sorting()
    {
        if (!isset($this->filters['id']) || !is_array($this->filters['id'])) {
            return $this;
        }
        
        $result = array();
        foreach ($this->filters['id'] as $id) {
            foreach ($this->result_data as $data) {
                if ($data['id'] == $id) {
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
            $this->pull = $this->getData()->getActiveDatas($this->getModelType());
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
}