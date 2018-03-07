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

namespace WPObjects\EventManager;

class Manager
{
    protected $listeners = array();
    
    public function trigger($event)
    {
        $listeners = isset($this->listeners[$event]) ? $this->listeners[$event] : array();
        
        foreach ($listeners as $listener) {
            if (!is_callable($listener)) {
                throw new \Exception('Listener not callable!');
            }
            
            $result = call_user_func($listener, $this);
            if ($result === false) {
                break;
            }
        }
        
        return $this;
    }
    
    public function attachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener)
    {
        $Listener->attach($this);
        
        return $this;
    }
    
    public function detachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener)
    {
        $Listener->detach($this);
        
        return $this;
    }
    
    public function detach($event, $cellable)
    {
        $listeners = $this->getEventListeners($event);
        foreach ($listeners as $key =>  $listener) {
            if ($cellable === $listener) {
                unset($listeners[$key]);
            }
        }
        
        $this->setEventListeners($event, $listeners);
        
        return $this;
    }
    
    public function attach($event, $cellable)
    {
        if (!is_array($this->listeners)) {
            $this->listeners = array();
        }
        
        if (!isset($this->listeners[$event]) || !is_array($this->listeners[$event])) {
            $this->listeners[$event] = array();
        }
        
        $this->listeners[$event][] = $cellable;
        
        return $this;
    }
    
    public function cleanListeners($event)
    {
        if (isset($this->listeners[$event])) {
            unset($this->listeners[$event]);
        }
        
        return $this;
    }
    
    /**
     * @param string $event
     * @return callable
     */
    protected function getEventListeners($event)
    {
        return isset($this->listeners[$event]) ? $this->listeners[$event] : array();
    }
    
    protected function setEventListeners($event, $listeners)
    {
        $this->listeners[$event] = $listeners;
        
        return $this;
    }
}