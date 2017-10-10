<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

abstract class AbstractFactory implements 
    FactoryInterface,
    AutocompeleInterface
{
    /**
     * If relative model is 'organisation' in query this as metaquery '_organisation_id'
     * @var type 
     */
    protected $relative_models_types = array();
    
    protected $context_models_types = array();
    
    protected $result_as_object = false;
    
    protected $result = null;
    
    protected function setResult($result)
    {
        $this->result = $result;
        
        return $this;
    }
    
    public function getResultIds()
    {
        $result_ids = array();
        foreach ($this->getResult() as $Model) {
            $result_ids[] = $Model->getId();
        }
        
        return $result_ids;
    }
    
    public function getResult()
    {
        return $this->result;
    }
    
    protected function getContextTypes()
    {
        return $this->context_models_types;
    }
    
    public function getModelType()
    {
        if (is_null($this->model_type)) {
            throw new \Exception('Undefiend model type!');
        }
        
        return $this->model_type;
    }
    
    /**
     * @param string $string
     * @return array()
     */
    static public function prepareMetaValue($string)
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
    
    /**
     * If type name 'organisations' then specialization attr will be 'organisation' with out 's'.
     * What is 'specialization' - read UML2 
     * @param string $type
     * @return string
     */
    static public function getSpecializationAttrName($type)
    {
        $last_char = substr($type, -1);
        if ($last_char === 's') {
            $type = substr($type, 0, -1);
        }
        
        return '_' . $type . '_id';
    }
}