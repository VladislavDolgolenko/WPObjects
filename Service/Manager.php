<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Service;

class Manager 
{
    protected $initialized = array();
    
    protected $config = array();
    
    private static $_instance = null;
    
    /**
    * @return \MSP\Data\Data
    */
    static public function getInstance()
    {
        $class = get_called_class();
        if (is_null(self::$_instance)) {
            self::$_instance = new $class();
        }
        
        return self::$_instance;
    }
    
    public function __construct($config)
    {
        $this->addConfig($config);
    }
    
    public function addConfig($config)
    {
        $this->config = array_merge($this->config, $config);
        
        return $this;
    }
    
    public function get($name)
    {
        if (isset($this->initialized[$name])) {
            return $this->initialized[$name];
        }
        
        if (!isset($this->config[$name])) {
            throw new \Exception('Service not found');
        }
        
        $service_factory = $this->config[$name];
        if (is_callable($service_factory)) {
            $this->initialized[$name] = $service_factory($this);
        } else if (class_exists($service_factory)) {
            $this->initialized[$name] = new $service_factory($this);
        } else {
            throw new \Exception('Incorrect service factory');
        }
        
        return $this->initialized[$name];
    }
    
    public function set($name, $value)
    {
        $this->initialized[$name] = $value;
        
        return $this;
    }
    
    public function addFactory($name, $cellable)
    {
        if (!is_callable($cellable)) {
            throw new \Exception('Not callable fatory');
        }
        
        $this->config[$name] = $cellable;
        return $this;
    }
    
    public function addClass($name, $class_name)
    {
        $this->config[$name] = $class_name;
        
        return $this;
    }
}