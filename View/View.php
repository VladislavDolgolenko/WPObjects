<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\View;

class View implements
    \WPObjects\View\ViewInterface,
    \WPObjects\AssetsManager\AssetsManagerInterface,
    \WPObjects\Service\ManagerInterface
{
    protected $template_path = null;
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    /**
     * Global service manager
     * 
     * @var \WPobjects\Service\Manager
     */
    protected $ServiceManager = null;
    
    public function getTemplatePath()
    {
        return $this->template_path;
    }
    
    public function setTemplatePath($string)
    {
        $this->template_path = $string;
        
        return $this;
    }
    
    public function enqueues()
    {
        
    }
    
    public function render()
    {
        $template_path = $this->getTemplatePath();
        if (!\file_exists($template_path)) {
            return;
        }
        
        $this->enqueues();
        include($template_path);
    }
    
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM)
    {
        $this->AssetsManager = $AM;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager()
    {
        return $this->AssetsManager;
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
            throw new \Exception('ServiceManager is undefined');
        }
        
        return $this->ServiceManager;
    }
}