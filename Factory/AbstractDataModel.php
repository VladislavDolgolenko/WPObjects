<?php

/**
 * @encoding     UTF-8
 * @package      WPObjects
 * @link         https://github.com/VladislavDolgolenko/WPObjects
 * @copyright    Copyright (C) 2018 Vladislav Dolgolenko
 * @license      MIT License
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      <help@vladislavdolgolenko.com>
 */

namespace WPObjects\Factory;

class AbstractDataModel extends AbstractData implements
    \WPObjects\Model\ModelTypeInterface
{
    /**
     * Object ModelType of current factory objects
     * @var \WPObjects\Model\AbstractModelType
     */
    protected $ModelType = null;
    
    /**
    * @return \WPObjects\Model\AbstractModelType
    */
    public function getModelType()
    {
        if (is_null($this->ModelType)) {
            throw new \Exception('Undefiend model type in' . get_class($this));
        }
        
        return $this->ModelType;
    }
    
    public function setModelType(\WPObjects\Model\AbstractModelType $ModelType)
    {
        $this->ModelType = $ModelType;
        
        return $this;
    }
    
    public function getStorage()
    {
        $Storage = parent::getStorage();
        if ($Storage) {
            return $Storage;
        }
        
        if (!$this->getModelType() instanceof \WPObjects\Data\DataType) {
            throw new \Exception('Model type in data model fatory must be instance of \WPObjects\Data\DataType');
        }
        
        return $this->getModelType()->getStorage();
    }
    
    public function initModel($post)
    {
        return $this->getModelType()->initModel($post);
    }
    
    public function getIdAttrName()
    {
        return $this->getModelType()->getIdAttrName();
    }
}