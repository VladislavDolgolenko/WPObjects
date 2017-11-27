<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\AssetsManager;

/**
 * - логика работы с глобальной JS переменной и шаблонами 
 * - регистрировать глобальные скрипты
 */
class AssetsManager implements
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\Service\VersionInterface
{
    protected $namespace = '';
    protected $global_assets = array();
    protected $assets_version = '';
    protected $js_templates = array();
    
    public function __construct()
    {
        \add_action('wp_print_footer_scripts', array($this, 'updateJSObject'), -10);
        \add_action('admin_print_footer_scripts', array($this, 'updateJSObject'), -10);
    }
    
    public function registerScripts($config)
    {
        foreach ($config as $script) {
            list($name, $path, $deps, $v, $global) = $script;
            $this->registerScript($name, $path, $deps, $v, $global);
        }
        
        return $this;
    }
    
    public function registerScript($name, $path, $deps = array(), $v = null, $global = false)
    {
        if (\wp_script_is($name, 'registered')) {
            return $this;
        }
        
        if ($global) {
            $this->addGlobalScript($name);
        }
        
        $version = $v ? $v : $this->getVersion();
        
        \wp_register_script($this->prepareAssetName($name), $path, $this->prepareAssetsDeps($deps), $version);
        
        return $this;
    }
    
    public function registerStyles($config)
    {
        foreach ($config as $style) {
            list($name, $path, $deps, $v, $global) = $style;
            $this->registerStyle($name, $path, $deps, $v, $global);
        }
        
        return $this;
    }
    
    public function registerStyle($name, $path, $deps = array(), $v = null, $global = false)
    {
        if (\wp_style_is($name, 'registered')) {
            return $this;
        }
        
        if ($global) {
            $this->addGlobalScript($name);
        }
        
        $version = $v ? $v : $this->getVersion();
        
        \wp_register_style($this->prepareAssetName($name), $path, $this->prepareAssetsDeps($deps), $version);
        
        return $this;
    }
    
    public function addGlobalScript($name)
    {
        if (!in_array($name, $this->global_assets)) {
            $this->global_assets[] = $name;
        }
        
        return $this;
    }
    
    public function addJSTemplate($name, $path)
    {
        $this->js_templates[$name] = $path;
        
        return $this;
    }
    
    public function enqueueScript($name)
    {
        \wp_enqueue_script($this->prepareAssetName($name));
        
        return $this;
    }
    
    public function enqueueStyle($name)
    {
        \wp_enqueue_style($this->prepareAssetName($name));
        
        return $this;
    }
    
    public function updateJSObject()
    {
        \wp_localize_script('backbone', $this->getNamespace(), $this->getJSObject());
    }
    
    public function getJSObject()
    {
        return array_merge(array(
            'nonce' => \wp_create_nonce('wp_rest'),
            'rest_url' => \get_rest_url() . $this->getNamespace()
        ), $this->getJSTemplatesContents());
    }
    
    public function getJSTemplatesContents()
    {
        $result = array();
        foreach ($this->js_templates as $name => $path) {
            $result[$name] = file_get_contents($path);
        }
        
        return $result;
    }
    
    /**
     * Prepare dependencies names based on current namespace
     * 
     * @param array $deps
     * @return string
     */
    public function prepareAssetsDeps($deps)
    {
        $result = array();
        foreach ($deps as $dep) {
            $result[] = $this->prepareAssetName($dep);
        }
        
        return $result;
    }
    
    public function prepareAssetName($name)
    {
        if (!in_array($name, $this->global_assets)) {
            return $this->getNamespace() . '_' . $name;
        } else {
            return $name;
        }
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