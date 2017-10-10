<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractTypicalModel extends AbstractModel implements
    ModelTypeInterface
{
    
    /**
     * @var \WPObjects\Model\AbstractModelType
     */
    protected $ModelType = null;
    
    /**
     * @var \WPObjects\Model\AbstractTypicalModel in array
     */
    protected $relatives = array();
    
    public function __construct($data, \WPObjects\Model\AbstractModelType $ModelType)
    {
        parent::__construct($data);
        $this->ModelType = $ModelType;
    }
    
    abstract public function getMeta($key);
    
    abstract public function save();
    
    abstract public function setMeta($key, $value);
    
    /**
     * @param AbstractFactory $Factory
     * @return \WPObjects\Model\AbstractModel || array
     */
    protected function getRelative(\WPObjects\Factory\AbstractFactory $Factory, $filters = array(), $single = true)
    {
        $model_type_id = $Factory->getModelType();
        if (isset($this->relatives[$model_type_id])) {
            return $this->relatives[$model_type_id];
        }
        
        $relative_model_id = $this->getRelativeId($Factory);
        if (!$relative_model_id) {
            return null;
        }
        
        $Model = $Factory->get($relative_model_id, $filters, $single);
        $this->relatives[$model_type_id] = $Model;
        return $Model;
    }
    
    protected function getRelativeId(\WPObjects\Factory\AbstractFactory $Factory)
    {
        $model_type_id = $Factory->getModelType();
        $attr = AbstractFactory::getSpecializationAttrName($model_type_id);
        $relative_model_id = $this->getMeta($attr);
        
        return $relative_model_id ? $relative_model_id : null;
    }
    
    protected function getInRelative(\WPObjects\Factory\AbstractFactory $Factory, $filters = array())
    {
        $model_type_id = $Factory->getModelType();
        if (isset($this->parent_relatives[$model_type_id])) {
            return $this->parent_relatives[$model_type_id];
        }
        
        $attr = AbstractFactory::getSpecializationAttrName($this->getModelType());
        $Factory->query(array_merge(array(
            $attr => $this->getId()
        )), $filters);
        
        $this->parent_relatives[$model_type_id] = $Factory->getResult();
        return $this->parent_relatives[$model_type_id];
    }
    
    public function getModelType()
    {
        if (!$this->ModelType) {
            throw new \Exception('Undefined model type');
        }
        
        return $this->ModelType;
    }
}