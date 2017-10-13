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
    
    protected $context_models_types = array();
    
    /**
     * Register filters as types of classes by qualifier objects
     * @var array
     */
    protected $context_models_methods = array();
    
    /**
     * Query flag. How to create result object. If true, result must be instance of \WP_Query
     * @var boolean
     */
    protected $result_as_object = false;
    
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
        
        if (\get_post_type($post->ID) === $this->getModelType()) {
            $this->filters['id'] = $post->ID;
            return $this;
        }
        
        foreach ($this->getQualifiersFilters() as $type) {
            if (get_post_type($post->ID) == $type) {
                $this->setIdsFromContext($post, $type);
                return $this;
            }
        }
        
        return $this;
    }
    
    protected function setIdsFromContext($post, $type)
    {
        $attr = $this->getSpecializationAttrName($type);
        if (!isset($this->context_models_methods[$type])) {
            $this->filters[$attr] = $post->ID;
        } else {
            $method = $this->context_models_methods[$type];
            $ids = $this->$method($post);
            $this->filters['post__in'] = $ids;
        }
        
        return $this;
    }
    
    public function getQualifiersFilters()
    {
        return array();
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
     * Return registered context models types
     * @return array
     */
    protected function getContextTypes()
    {
        return $this->context_models_types;
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