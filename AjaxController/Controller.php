<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AjaxController;

abstract class Controller implements \WPObjects\EventManager\ListenerInterface
{
    protected $id = null;
    
    public function attach()
    {
        if (!$this->getId()) {
            return false;
        }
        
        return \add_action( 'wp_ajax_' . $this->getId(), array($this, 'render') );
    }
    
    public function detach()
    {
        return \remove_action( 'wp_ajax_' . $this->getId(), array($this, 'render') );
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
}