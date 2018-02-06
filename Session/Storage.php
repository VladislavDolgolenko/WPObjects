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
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Session\CookiesInterface
{
    protected $namespace = '';
    
    protected $data = array();
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    /**
     * @var \WPObjects\Session\Cookies
     */
    protected $Cookies = null;
    
    public function attach()
    {
        if (\did_action('init')) {
            $this->initSession();
            $this->initStorage();
        } else {
            \add_action('init', array($this, 'initSession'), 10);
            \add_action('init', array($this, 'initStorage'), 11);
        }
    }
    
    public function detach()
    {
        \remove_action('init', array($this, 'initSession'), 10);
        \remove_action('init', array($this, 'initStorage'), 11);
    }
    
    public function initStorage()
    {
        $storage_data = $this->getStoragesData();
        if (isset($storage_data[$this->getSessionId()])) {
            $this->data = $storage_data[$this->getSessionId()];
        }
        
        return $this;
    }
    
    public function initSession()
    {
        $session_id = $this->getCookies()->get('session_id', null);
        if (!$session_id) {
            $session_id = $this->regenerateSessionId();
            $this->getCookies()->set('session_id', $session_id);
        }
        
        return $this;
    }
    
    protected function regenerateSessionId()
    {
        $session_id = uniqid($this->getNamespace(), true);
        $storages_data = $this->getStoragesData();
        if (isset($storages_data[$session_id])) {
            return $this->regenerateSessionId();
        }
        
        return $session_id;
    }
    
    public function getSessionId()
    {
        return $this->getCookies()->get('session_id', null);
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
        $storages_data = $this->getStoragesData();
        
        $storages_data[$this->getSessionId()] = $data;
        $this->setStoragesData($storages_data);
        
        return $this;
    }
    
    public function getStoragesData()
    {
        $storages_data = \get_option($this->getStorageKey(), array());
        if (!is_array($storages_data)) {
            $storages_data = array();
        }
        
        return $storages_data;
    }
    
    public function setStoragesData($data)
    {
        \update_option($this->getStorageKey(), $data);
        
        return $this;
    }
    
    protected function getStorageKey()
    {
        return $this->getNamespace() . '_session_storage';
    } 
    
    /**
     * Return current session data
     * 
     * @return array
     */
    public function getData()
    {
        $data = $this->data;
        if (!is_array($data)) {
            $data = array();
        }
        
        return $data;
    }
    
    protected function setData($array)
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
    
    public function setCookies(\WPObjects\Session\Cookies $Cookies)
    {
        $this->Cookies = $Cookies;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\Session\Cookies
     */
    public function getCookies()
    {
        if (is_null($this->Cookies)) {
            throw new \Exception('Undefined \WPObjects\Session\Cookies object');
        }
        
        return $this->Cookies;
    }
}