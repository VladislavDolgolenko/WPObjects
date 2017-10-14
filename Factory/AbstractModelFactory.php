<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

abstract class AbstractModelFactory implements 
    FactoryInterface,
    AutocompeleInterface,
    \WPObjects\Service\ManagerInterface
{
    /**
     * @var \WPObjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    /**
     * Register special methods for reading global WordPress page context 
     * as object of model type. Methods must return ids of current model type.
     * @var array of callable functions
     */
    protected $context_methods_reading = array();
    
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
     * Object ModelType of current factory objects
     * @var \WPObjects\Model\AbstractModelType
     */
    protected $ModelType = null;
    
    /**
     * Last query results as initialized objects 
     * @var array
     */
    protected $result = null;
    
    abstract public function initModel($post);
    
    protected function readContext()
    {
        global $post;
        
        if (!isset($this->filters['page_context'])) {
            return $this;
        }
        
        // Own context if first rule
        if (\get_post_type($post->ID) === $this->getModelType()) {
            $this->filters['id'] = $post->ID;
            return $this;
        }
        
        foreach ($this->getContextModelTypes() as $type_id) {
            if (get_post_type($post->ID) == $type_id) {
                $this->setIdsFromContext($post, $type_id);
                return $this;
            }
        }
        
        return $this;
    }
    
    protected function setContext($post, $type)
    {
        $attr = $this->getSpecializationAttrName($type);
        
        if (!isset($this->context_methods_reading[$type]) && is_callable($this->context_methods_reading[$type])) {
            $this->filters[$attr] = $post->ID;
        } else {
            $method = $this->context_methods_reading[$type];
            $method->bindTo($this);
            $this->filters['post__in'] = $method($post);
        }
        
        return $this;
    }
    
    protected function getContextModelTypes()
    {
        return array_merge($this->getQualifiersIds(), $this->getAgregatorsIds());
    }
    
    /**
     * Build filters by aggregators of current model type.
     */
    protected function buildfilterByAgregators()
    {
        $filters = $this->filters;
        $ModelType = $this->getModelType();
        if (!$ModelType instanceof \WPObjects\Model\AbstractModelType) {
            throw new \Exception('Undefined ModelType of current query objects');
        }
        
        foreach ($filters as $model_type_id => $value) {
            $AgregatorType = $this->getAgregatorType($model_type_id);
            if (!$AgregatorType) {
                continue;
            }
            
            $Factory = $AgregatorType->getFactory();
            if (!$Factory instanceof \WPObjects\Factory\AbstractModelFactory) {
                throw new \Exception('Undefined factory of agregator type');
            }
            
            $filter_ids = array();
            $AgregatorsObjects = $Factory->get($value);
            $qualifier_attr_name = $ModelType->getOwnQualifierAttrName();
            foreach ($AgregatorsObjects as $AgregatorObject) {
                $ids = $AgregatorObject->getMeta($qualifier_attr_name);
                if (!is_array($ids)) {
                    $ids = array($ids);
                }
                $filter_ids[] = $ids;
            }
            
            // Это пизда post__in
            $this->filters['id'] = array_filter($filter_ids);
        }
        
        return $this;
    }
    
    /**
     * Return aggregators type by own qualifier attr
     * @param string $id
     * @return \WPObjects\Model\AbstractModelType
     */
    protected function getAgregatorType($agregator_id)
    {
        return $this->getModelType()->getAgregator($agregator_id);
    }
    
    /**
     * Return ids qualifiers types
     * @return array
     */
    protected function getQualifiersIds()
    {
        return array();
    }
    
    protected function getAgregatorsIds()
    {
        return array();
    }

    /**
     * @return \WPObjects\Model\AbstractModelType
     */
    protected function getQualifiers()
    {
        return array();
    }
    
    protected function getQualifiersAttrsNames()
    {
        $result = array();
        foreach ($this->getQualifiers() as $QualifierModelType) {
            $result[] = $QualifierModelType->getOwnQualifierAttrName();
        }
        
        return $result;
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
    
    /**
     * @return \WPObjects\Model\AbstractModelType
     */
    public function getModelType()
    {
        if (is_null($this->ModelType)) {
            throw new \Exception('Undefiend model type!');
        }
        
        return $this->ModelType;
    }
    
    public function setModelType(\WPObjects\Model\AbstractModelType $ModelType)
    {
        $this->ModelType = $ModelType;
        
        return $this;
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
}