<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

/**
 * Load addons from directory structure:
 * 
 * ./addons_folder
 *      ./addon_name_folder
 *          ./addon.less
 *          ./addon.less
 *          ./addon.js
 *          ./template.php
 *          ./less_params.php
 * 
 */
class AddonsLoader implements 
    \WPObjects\EventManager\ListenerInterface,
    \WPObjects\Service\ManagerInterface
{
    protected $base_folder_path = null;
    protected $addon_model_class_name = '\WPObjects\VC\CustomAddonModel';
    protected $Addons = array();

    public function load()
    {
        $data = $this->readFolder($this->getBaseFolderPath());
        
        $result = array();
        foreach ($data as $addon) {
            $Addon = new $this->addon_model_class_name($addon); 
            $Addon->attach();
            $result[] = $Addon;
        }
        
        $this->Addons = $result;
        
        return $this;
    }
    
    static public function readFolder($addons_folder_path)
    {
        return array();
    }
    
    public function attach()
    {
        if (\did_action('plugins_loaded')) {
            $this->load();
        } else {
            add_action('plugins_loaded', array($this, 'load'));
        }
    }
    
    public function detach()
    {
        remove_action('plugins_loaded', array($this, 'load'));
    }
    
    public function setBaseFolderPath($path)
    {
        $this->base_folder_path = $path;
        
        return $this;
    }
    
    public function getBaseFolderPath()
    {
        return $this->base_folder_path;
    }
    
    public function setServiceManager(\WPObjects\Service\Manager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
        
        return $this;
    }
    
    public function getServiceManager()
    {
        if (is_null($this->ServiceManager)) {
            throw new \Exception('Undefined service manager');
        }
        
        return $this->ServiceManager;
    }
}