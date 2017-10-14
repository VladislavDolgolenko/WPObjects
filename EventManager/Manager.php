<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\EventManager;

class Manager
{
    protected $listeners = array();
    
    public function trigger($event)
    {
        $listeners = isset($this->listeners[$event]) ? $this->listeners[$event] : array();
        
        foreach ($listeners as $listener) {
            if (is_array($listener) && is_callable($listener[1]) && is_object($listener[0])) {
                $context = $listener[0];
                $method = $listener[1];
            } else if (is_callable($listener)) {
                $method = $listener;
                $context = $this;
            } else {
                throw new \Exception('Undefined listener type');
            }
            
            $method->bindTo($context);
            $result = $method($this);
            if ($result === false) {
                break;
            }
        }
        
        return $this;
    }
    
    public function addListener($event, $cellable)
    {
        if (!is_array($this->listeners)) {
            $this->listeners = array();
        }
        
        if (!is_array($this->listeners[$event])) {
            $this->listeners[$event] = array();
        }
        
        $this->listeners[$event][] = $cellable;
        
        return $this;
    }
}