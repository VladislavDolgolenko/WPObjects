<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

use WPObjects\PostType\PostType;

class Manager implements \WPObjects\EventManager\ListenerInterface
{
    /**
     * @var \WPObjects\PostType\PostType
     */
    protected $PostTypes = array();
    
    /**
     * @var array
     */
    protected $config = array();
    
    public function __construct($config = array())
    {
        $this->setConfig($config);
    }
    
    /**
     * @return $this
     */
    public function init()
    {
        $this->PostTypes = array();
        foreach ($this->getConfig() as $id => $config) {
            $PostType = new PostType($id);
            $PostType->setConfig($config);
            $this->PostTypes[] = $PostType;
        }
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function add(\WPObjects\PostType\PostType $PostType)
    {
        if (!$this->get($PostType->getId())) {
            $this->PostTypes[] = $PostType;
        }
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function attach()
    {
        foreach ($this->getAll() as $PostType) {
            $PostType->attach();
        }
        
        return $this;
    }
    
    /**
     * @return $this
     */
    public function detach()
    {
        foreach ($this->getAll() as $PostType) {
            $PostType->detach();
        }
        
        return $this;
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    public function getAll()
    {
        return $this->PostTypes;
    }
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    public function get($id)
    {
        foreach ($this->getPostTypes() as $PostType) {
            if ($id === $PostType->getId()) {
                return $PostType;
            }
        }
        
        return null;
    }
    
}