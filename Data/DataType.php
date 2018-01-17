<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

use WPObjects\Model\AbstractModelType;

class DataType extends AbstractModelType implements
    \WPObjects\Data\StorageInterface
{
    /**
     * @var \WPObjects\Data\Storage
     */
    protected $Storage = null;

    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getStorage()
    {
        if (is_null($this->Storage)) {
            $this->Storage = new Storage($this->storage);
        }
        
        return $this->Storage;
    }
    
    public function setStorage(\WPObjects\Data\AbstractStorage $Storage)
    {
        $this->Storage = $Storage;
    }
    
    public function getModelClassName()
    {
        if (!isset($this->model_class_name)) {
            throw new \Exception('Undefined data type mode class name');
        }
        
        return $this->model_class_name;
    }
        
    public function getAddNewLink()
    {
        return admin_url( 'admin.php?page=database');
    }
}