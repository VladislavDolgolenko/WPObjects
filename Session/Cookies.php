<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Session;

class Cookies implements
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\EventManager\ListenerInterface
{
    protected $namespace = '';
    
    protected $data = array();
    
    public function attach()
    {
        if (\did_action('sanitize_comment_cookies')) {
            $this->initCookies();
        } else {
            \add_action('sanitize_comment_cookies', array($this, 'initCookies'));
        }
        
        \add_action('send_headers', array($this, 'update'));
    }
    
    public function detach()
    {
        \remove_action('send_headers', array($this, 'update'));
    }
    
    /**
     * Must be called after 'sanitize_comment_cookies' and before 'send_headers' WordPress system actions
     * 
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $cookie_key = $this->getNamespace() . '_' . $key;
        $this->data[$cookie_key] = $value;
        
        return $this;
    }
    
    public function get($key, $default = null)
    {
        $cookie_key = $this->getNamespace() . '_' . $key;
        return isset($this->data[$cookie_key]) ? $this->data[$cookie_key] : $default;
    }
    
    public function initCookies()
    {
        if (isset($_COOKIE) && is_array($_COOKIE)) {
            $data = array();
            foreach ($_COOKIE as $key => $value) {
                $data[$key] = $value;
                
            }
            $this->setData($data);
        }
        
        return $this;
    }
    
    public function update()
    {
        $data = $this->getData();
        if (!is_array($data)) {
            $data = array();
        }
        
        foreach ($data as $key => $value) {
            if (isset($_COOKIE[$key]) && $_COOKIE[$key] == $value) {
                continue;
            }
            
            \setcookie($key, $value, time() + DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
        }
        
        return $this;
    }
    
    protected function getData()
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
}