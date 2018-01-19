<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AjaxController;

abstract class Controller implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Service\ManagerInterface
{
    protected $id = null;
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    public function attach()
    {
        if (!$this->getId()) {
            return false;
        }
        
        \add_action( 'wp_ajax_' . $this->getId(), array($this, 'render') );
        \add_action( 'wp_ajax_nopriv_' . $this->getId(), array($this, 'render') );
    }
    
    public function detach()
    {
        \remove_action( 'wp_ajax_' . $this->getId(), array($this, 'render') );
        \remove_action( 'wp_ajax_nopriv_' . $this->getId(), array($this, 'render') );
    }
    
    public function render()
    {
        $body = $this->getBody();
        if (!$body) {
            die('{}');
        }
        
        echo $body;
        die();
    }
    
    abstract protected function getBody();
    
    public function getId()
    {
        return $this->id;
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