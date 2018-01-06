<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

use WPObjects\Model\AbstractModel;

abstract class AbstractStorage extends AbstractModel implements
    StorageDataInterface
{
    protected $id = null;
    
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
    
    /**
     * Return storage data
     * 
     * @return array
     */
    abstract public function getData();
    
    public function setData($data)
    {
        $this->data = $data;
        
        return $this;
    }
}