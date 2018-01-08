<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractDataModel extends AbstractTypicalModel implements
    \WPObjects\Data\DataAccessInterface
{
    /**
     * @var \WPObjects\Data\Data
     */
    protected $DataAccess = null;

    public function getId()
    {
        $attr = $this->getModelType()->getIdAttrName();
        if (isset($this->$attr)) {
            return $this->$attr;
        }
        
        return null;
    }
    
    /**
     * Get associated model identities
     * @param string $model_type_id
     */
    public function getQualifierId($model_type_id)
    {
        $attr_name = $this->getModelType()->getQualifierAttrName($model_type_id);
        if (isset($this->$attr_name)) {
            return $this->$attr_name;
        }
        
        return null;
    }
    
    /**
     * Set association with other typical model instance 
     * @param string $model_type_id
     * @param int $model_id
     * @return $this
     */
    public function setQualifierId($model_type_id, $model_id)
    {
        $attr_name = $this->getModelType()->getQualifierAttrName($model_type_id);
        $this->$attr_name = $model_id;
        
        return $this;
    }
    
    public function isBuildIn()
    {
        if (isset($this->build_in) && $this->build_in === true) {
            return true;
        }
        
        return false;
    }
    
    public function isActive()
    {
        if (isset($this->active) && $this->active === true) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Save or update model in database as WordPress options.
     * If current model is build in, saving do nothing.
     * 
     * @return $this
     */
    public function save()
    {
        $DataAccess = $this->getDataAccess();
        $DataAccess->saveModel($this);
        
        return $this;
    }
    
    public function delete()
    {
        $DataAccess = $this->getDataAccess();
        $DataAccess->deleteModel($this);
        
        return $this;
    }
    
    public function setDataAccess(\WPObjects\Data\Data $Data)
    {
        $this->DataAccess = $Data;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Data\Data
     */
    public function getDataAccess()
    {
        return $this->DataAccess;
    }
}
