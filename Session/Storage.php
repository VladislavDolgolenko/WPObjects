<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Session;

class Storage implements 
    \WPObjects\Service\ManagerInterface,
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\EventManager\ListenerInterface
{
    protected $namespace = '';
    
    protected $time_life = 3600 * 12 * 30;

    protected $data = array();
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    public function __construct()
    {
        
    }
    
    public function attach()
    {
        \add_action('sanitize_comment_cookies', array($this, 'initCookies'));
        \add_action('send_headers', array($this, 'update'));
    }
    
    public function detach()
    {
        \remove_action('send_headers', array($this, 'update'));
    }
    
    public function initCookies()
    {
        if (isset($_COOKIE[$this->getNamespace()])) {
            $current_data = $_COOKIE[$this->getNamespace()];
            if (is_string($current_data)) {
                $data = json_decode($current_data);
                $this->setData($data);
            }
        }
    }
    
    public function set($key, $value)
    {
        $this->data[$key] = $value;
        
        return $this;
    }
    
    public function get($key, $default = null)
    {
        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }
    
    public function update()
    {
        $data = $this->getData();
        if (!is_array($data)) {
            $data = array();
        }
        
        $clear_data = array_filter($data);
        $insert_data = json_encode($clear_data);
        
        \setcookie($this->getNamespace(), $insert_data, $this->getTimeLine() + time(), '/');
        
        return $this;
    }
    
    public function getData()
    {
        return $this->data;
    }
    
    public function setData($array)
    {
        $this->data = $array;
        
        return $this;
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    public function setTimeLive($int)
    {
        $this->time_life = $int;
        
        return $this;
    }
    
    public function getTimeLine()
    {
        return $this->time_life;
    }
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Service\Manager
     * @throws \Exception
     */
    public function getServiceManager()
    {
        if (is_null($this->ServiceManager)) {
            throw new \Exception('Undefined service manager');
        }
        
        return $this->ServiceManager;
    }
}