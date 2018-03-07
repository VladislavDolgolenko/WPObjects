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

namespace WPObjects\Data;

use WPObjects\Model\AbstractModel;

abstract class AbstractStorage extends AbstractModel implements
    StorageDataInterface
{
    protected $id = null;
    
    protected $is_close = false;
    
    /**
     * Cached storage data 
     * 
     * @var array
     */
    protected $data = array();
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return ucfirst( str_replace(array('-', '_'), ' ', $this->id) );
    }
    
    public function close()
    {
        $this->is_close = true;
        $this->data = array();
        
        return $this;
    }
    
    public function isOpen()
    {
        return $this->is_close ? false : true;
    }
    
    public function open()
    {
        $this->is_close = false;
        
        return $this;
    }
    
    /**
     * Return storage data
     * 
     * @return array
     */
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }
        
        if ($this->isOpen()) {
            $this->data = $this->readStorage();
        }
        
        return $this->data;
    }
    
    abstract public function readStorage();
    
    public function setData($data)
    {
        $this->data = $data;
        
        return $this;
    }
}