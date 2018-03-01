<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

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
class Storage extends \WPObjects\Data\AbstractStorage implements
    \WPObjects\AssetsManager\AssetsManagerInterface,
    \WPObjects\Service\NamespaceInterface
{
    protected $base_folder_path = null;
    protected $template_file_name = 'template.php';
    protected $config_file_name = 'config.php';
    protected $less_params_file_name = 'less.php';
    protected $presets_file_name = 'presets.php';
    
    protected $param_model_class_name = '\WPObjects\LessCompiler\ParamModel';
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    protected $namespace = null;

    /**
     * Register styles and scripts
     * 
     * @param type $addons_folder_path
     * @return type
     */
    public function readStorage()
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
                $asset_name = $name . '-' . current(explode('.', $file));
                $dir_url = \plugin_dir_url( $shortcode_dir . DIRECTORY_SEPARATOR . $file ) ;
                $this->getAssetsManager()->registerStyle($asset_name, $dir_url . $file, $styles_deps);
                $addon['enqueue_styles'][] = $this->getAssetsManager()->prepareAssetName($asset_name);
                continue;
            } 
            
            if (preg_match('/.js/', $file)) {
                $asset_name = $name . current(explode('.', $file));
                $dir_url = \plugin_dir_url( $shortcode_dir . DIRECTORY_SEPARATOR . $file ) ;
                $this->getAssetsManager()->registerScript($asset_name, $dir_url . $file, $scripts_deps);
                $addon['enqueue_scripts'][] = $this->getAssetsManager()->prepareAssetName($asset_name);
                continue;
            } 
            
            if ($file === $this->template_file_name) {
                $addon['html_template'] = $shortcode_dir . DIRECTORY_SEPARATOR . $file;
                continue;
            }
            
            if ($file === $this->presets_file_name) {
                $presets_data = include ($shortcode_dir . DIRECTORY_SEPARATOR . $file);
                $addon['Presets'] = $this->initPresets($presets_data, $name);
                continue;
            }
            
            if ($file === $this->less_params_file_name) {
                $less_params = include ($shortcode_dir . DIRECTORY_SEPARATOR . $file);
                $addon['CustomizerSettings'] = $this->initLessParams($less_params, $name);                
                continue;
            }
            
        }
        
        return $addon;
    }
    
    protected function initPresets($presets_data, $addon_name)
    {
        $results = array();
        foreach ($presets_data as $data) {
            $Preset = new \WPObjects\Customizer\Preset\Model($data);
            $this->getServiceManager()->inject($Preset);
            
            $Preset->setSettingsPregix($Preset->getNamespace() . $addon_name . '_');
            $results[] = $Preset;
        }
        
        return $results;
    }
    
    protected function initLessParams($params, $addon_name)
    {
        $result = array();
        foreach ($params as $key => $param) {
            if (is_string($key)) {
                $param['id'] = $key;
            }
            
            $param_model_class_name = $this->getParamModelClassName();
            $ParamModel = new $param_model_class_name($param);
            $this->getServiceManager()->inject($ParamModel);
            
            $ParamModel->setSettingName($ParamModel->getNamespace() . $addon_name . '_' . $param['id']);
            $result[] = $ParamModel;
        }
        
        return $result;
    }
    
    public function getParamModelClassName()
    {
        return $this->param_model_class_name;
    }
    
    public function setParamModelClassName($string)
    {
        $this->param_model_class_name = $string;
        
        return $this;
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