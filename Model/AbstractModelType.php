<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractModelType extends AbstractModel
{
    /**
     * @var \WPObjects\Model\ModelTypeFactory
     */
    protected $ModelTypeFactory = null;
    
    /**
     * Factory of current model type
     * @var \WPObjects\Factory\AbstractModelFactory
     */
    protected $Factory = null;
    
    /**
     * Qualifiers for object classes, 
     * there as qualifier meta attribute of current class object.
     * Qualifiers - is UML2 type of association (current object to other object)
     * @var array
     */
    protected $qualifiers = array();
    
    abstract public function getModelClassName();
    
    public function getRegisterQualifiersAttrs()
    {
        if (!is_array($this->register_qualifiers)) {
            $this->register_qualifiers = array();
        }
        
        $result = array();
        foreach ($this->qualifiers as $model_type_id) {
            $result[] = self::getQualifierAttrName($model_type_id);
        }
        
        return $result;
    }
    
    public function getQualifiersIds()
    {
        return $this->qualifiers;
    }
    
    public function getQualifiers()
    {
        return $this->getModelTypeFactory()->get($this->getQualifiersIds());
    }
    
    public function getAgregatorsIds()
    {
        return $this->getModelTypeFactory()->getAgregators($this)->getResultIds();
    }
    
    public function getAgregator($agregator_id)
    {
        $Result = $this->getModelTypeFactory()->getAgregator($this, $agregator_id)->getResult();
        return current($Result);
    }
    
    public function getFactory()
    {
        return $this->Factory;
    }
    
    public function setFactory(\WPObjects\Factory\AbstractModelFactory $Factory)
    {
        $this->Factory = $Factory;
        
        return $this;
    }
    
    public function getModelTypeFactory()
    {
        if (is_null($this->ModelTypeFactory)) {
            throw new \Exception('Undefined model type factory');
        }
        
        return $this->ModelTypeFactory;
    }
    
    public function setModelTypeFactory(\WPObjects\Model\ModelTypeFactory $Factory)
    {
        $this->ModelTypeFactory = $Factory;
    }
}