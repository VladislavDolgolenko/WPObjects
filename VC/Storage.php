<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

/**
 * Load addons from directory structure:
 * 
 * ./addons_folder
 *      ./addon_name_folder
 *          ./addon.less
 *          ./addon.js
 *          ./template.php
 *          ./less.php
 *          ./config.php
 * 
 */
class Storage extends WPObjects\Data\AbstractStorage implements
    WPObjects\Service\NamespaceInterface,
    WPObjects\Service\VersionInterface
{
    protected $namespace = '';
    protected $assets_version = '';
    protected $base_folder_path = null;
    protected $template_file_name = 'template.php';
    protected $config_file_name = 'config.php';
    protected $less_params_file_name = 'less.php';
    
    public function getData()
    {
        if (!is_null($this->data)) {
            return $this->data;
        }
        
        $this->data = $this->readFolder();
        
        return $this->data;
    }
    
    /**
     * Register styles and scripts
     * 
     * @param type $addons_folder_path
     * @return type
     */
    public function readFolder()
    {
        $list = $this->getList();
        
        $result = array();
        foreach ($list as $name) {
            $addon = $this->readAddonDir($name);
            if (is_array($addon) && isset($addon['base'])) {
                $result[] = $addon;
            }
        }
        
        return $result;
    }
    
    protected function readAddonDir($path_name)
    {
        $shortcode_dir = $this->getBaseFolderPath() . DIRECTORY_SEPARATOR . $path_name;
        $config_file_path = $this->getBaseFolderPath() . DIRECTORY_SEPARATOR . $path_name . DIRECTORY_SEPARATOR . $this->config_file_name;
        if (!file_exists($config_file_path)) {
            return array();
        }
        
        $addon = include $config_file_path;
        if (!isset($addon['base'])) {
            return array();
        }
        
        $name = $addon['base'];
        $addon['enqueue_styles'] = array();
        $addon['enqueue_scripts'] = array();
        $scripts_deps = isset($addon['scripts_deps']) ? $addon['scripts_deps'] : array();
        $styles_deps = isset($addon['styles_deps']) ? $addon['styles_deps'] : array();
        
        $files = scandir( $shortcode_dir );
        foreach ($files as $file) {
            
            if (preg_match('/.css|.less/', $file)) {
                $asset_name = $this->getNamespace() . $name . '-' . current(explode('.', $file));
                \wp_register_style($asset_name, '', $styles_deps, $this->getVersion());
                $addon['enqueue_styles'][] = $asset_name;
                continue;
            } 
            
            if (preg_match('/.js/', $file)) {
                $asset_name = $this->getNamespace() . $name . current(explode('.', $file));
                \wp_register_style($asset_name, '', $scripts_deps, $this->getVersion());
                $addon['enqueue_scripts'][] = $asset_name;
                continue;
            } 
            
            if ($file === $this->template_file_name) {
                $addon['html_template'] = $shortcode_dir . DIRECTORY_SEPARATOR . $file;
                continue;
            }
            
            if ($file === $this->less_params_file_name) {
                $addon['less_params'] = include ($shortcode_dir . DIRECTORY_SEPARATOR . $file);
                continue;
            }
            
        }
        
        return $addon;
    }
    
    protected function getList()
    {
        $shortcodes_dir = $this->getBaseFolderPath();
        $files = scandir( $shortcodes_dir );
        
        $list = array();
        foreach ($files as $file) {
            if (!is_dir($shortcodes_dir . '/' . $file) || $file == "." || $file == "..") {
                continue;
            }
            
            $list[] = $file;
        }
        
        return $list;
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
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
        
        return $this;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    public function setVersion($string)
    {
        $this->assets_version = $string;
        
        return $this;
    }
    
    public function getVersion()
    {
        return $this->assets_version;
    }
    
}