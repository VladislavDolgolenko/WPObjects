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
        $this->ModelType = $ModelType;
        parent::__construct($data);
    }
    
    public function toJSON()
    {
        $data = parent::toJSON();
        $data['id'] = $this->getId();
        
        return $data;
    }
    
    abstract public function save();
    
    abstract public function delete();
    
    abstract public function getQualifierId($model_type_id);
    
    abstract public function setQualifierId($model_type_id, $model_id);
    
    /**
     * Return relative (aggregated or aggregator) model by model type.
     * 
     * @param string|\WPObjects\Model\AbstractModelType $RelativeModelType object or identifier of relative model type 
     * @param array $filters 
     * @param boolean $single
     * @return \WPObjects\Model\AbstractTypicalModel 's in array
     * @throws \Exception
     */
    public function getRelative($RelativeModelType, $filters = array(), $single = true)
    {
        if (!$RelativeModelType instanceof \WPObjects\Model\AbstractModelType) {
            $RelativeModelType = $this->getModelType()->getModelTypeFactory()->get($RelativeModelType);
        }
        
        $model_type_id = $RelativeModelType->getId();
        if (isset($this->relatives[$model_type_id])) {
            return $this->relatives[$model_type_id];
        }
        
        $qualifiers = $this->getModelType()->getQualifiersIds();
        $agregators = $this->getModelType()->getAgregatorsIds();
        
        if (in_array($RelativeModelType->getId(), $qualifiers)) {
            
            $relative_ids = $this->getQualifierId($RelativeModelType->getId());
            $Result = $RelativeModelType->getFactory()->query(array(
                $RelativeModelType->getFactory()->getIdAttrName() => $relative_ids
            ), $filters)->getResult();
            
        } else if (in_array($RelativeModelType->getId(), $agregators)) {
            
            $qualifier_attr_name = $RelativeModelType->getQualifierAttrName($this->getModelType()->getId());
            $RelativeModelType->getFactory()->query(array(
                $qualifier_attr_name => $this->getId()
            ), $filters)->getResult();
            
        } else {
            throw new \Exception('Undefined relative model type');
        }
        
        if ($single === false) {
            $this->relatives[$model_type_id] = $Result;
        } else {
            $this->relatives[$model_type_id] = current($Result);
        }
        
        return $this->relatives[$model_type_id];
    }
    
    public function getRelativeId($RelativeModelType, $single = true)
    {
        $Relatives = $this->getRelative($RelativeModelType, array(), $single);
        if ($single) {
            return $Relatives->getId();
        }
        
        $result_ids = array();
        foreach ($Relatives as $Relative) {
            $result_ids[] = $Relative->getId();
        }
        
        return $result_ids;
    }
        
    /**
     * @return \WPObjects\Model\AbstractModelType
     */
    public function getModelType()
    {
        if (!$this->ModelType) {
            throw new \Exception('Undefined model type');
        }
        
        return $this->ModelType;
    }
    
}