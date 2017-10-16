<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractModelType extends AbstractModel implements
    \WPObjects\Service\ManagerInterface
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
    
    /**
     * Register special methods for reading global WordPress page context 
     * as object of model type. Methods must return ids of current model type.
     * @var array of callable functions
     */
    protected $context_methods_reading = array();
    
    abstract public function getModelClassName();
    
    /**
     * Initialize Model of current model type.
     * Use in factor method initModel
     * @param type $data
     * @return type
     */
    public function initModel($data)
    {
        $class = $this->getModelClassName();
        $Model = new $class($data, $this);
        return $this->getServiceManager()->inject($Model);
    }
    
    /**
     * Return special methods for reading global WordPress page context.
     * @param string $model_type_id
     * @return callable|null
     */
    public function getContextMethodReading($model_type_id)
    {
        if (isset($this->context_methods_reading[$model_type_id])) {
            return $this->context_methods_reading[$model_type_id];
        }
        
        return null;
    }
    
    /**
     * Return model type object of context of this context compatible
     * @param \WP_Post $post
     * @return \WPObjects\Model\AbstractModelType
     */
    public function getContextModelType($post)
    {
        $model_type_id = \get_post_type($post);
        if (!in_array($model_type_id, $this->getContextModelTypes())) {
            return null;
        }
        
        return $this->getModelTypeFactory()->get($model_type_id);
    }
    
    /**
     * Return all model types identities which can be context for current model type
     * @return array of identifiers
     */
    public function getContextModelTypes()
    {
        return array_merge($this->getQualifiersIds(), $this->getAgregatorsIds());
    }
    
    /**
     * Return all own attributes names that are qualifiers for other model types. For 
     * realization association.
     * @return array
     */
    public function getQualifiersAttrsNames()
    {
        $result = array();
        foreach ($this->getQualifiers() as $QualifierModelType) {
            $result[] = parent::getQualifierAttrName($QualifierModelType->getId());
        }
        
        return $result;
    }
    
    /**
     * Create qualifier attribute name, if model type is aggregator of current model type, 
     * returned with out changes. 
     * qualifier - is term of UML2
     * @param string $object_type_id
     * @return string
     */
    public function getQualifierAttrName($object_type_id)
    {
        if (in_array($object_type_id, $this->getQualifiersIds())) {
            return parent::getQualifierAttrName($object_type_id);
        }
        
        return $object_type_id;
    }
    
    /**
     * Return object of mode types that are aggregates for current model type
     * @return array of objects \WPObjects\Model\AbstractModelType
     */
    protected function getQualifiers()
    {
        return $this->getModelTypeFactory()->get($this->getQualifiersIds());
    }
    
    /**
     * Return identities of mode types that are aggregates for current model type.
     * @return type
     */
    public function getQualifiersIds()
    {
        return $this->qualifiers;
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