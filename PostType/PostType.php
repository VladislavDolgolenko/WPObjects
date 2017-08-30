<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

class PostType implements \WPObjects\EventManager\ListenerInterface
{
    protected $id = null;
    protected $config = array();
    
    public function attach()
    {
        \add_action('init', array($this, 'register'));
    }
    
    public function detach()
    {
        \remove_action('init', array($this, 'register'));
    }
    
    public function register()
    {
        \register_post_type($this->getId(), $this->getConfig());
    }
    
    public function setId($int)
    {
        $this->id = $int;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setConfig($config)
    {
        $this->config = $config;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}

