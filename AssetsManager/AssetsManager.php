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

namespace WPObjects\AssetsManager;

class AssetsManager implements
    \WPObjects\Service\NamespaceInterface,
    \WPObjects\Service\VersionInterface
{
    protected $namespace = '';
    protected $global_assets = array('jquery', 'backbone', 'underscore', 'jquery-ui');
    protected $assets_version = '';
    protected $js_templates = array();
    protected $wp_register_scripts = array();
    protected $wp_register_styles = array();
    
    public function __construct()
    {
        \add_action('wp_print_footer_scripts', array($this, 'updateJSObject'), -10);
        \add_action('admin_print_footer_scripts', array($this, 'updateJSObject'), -10);
        \add_action('wp_enqueue_scripts', array($this, 'registerWPAssets'), -10);
        \add_action('admin_enqueue_scripts', array($this, 'registerWPAssets'), -10);
    }
    
    public function registerScripts($config)
    {
        $this->registerAssets('wp_register_scripts', $config);
        
        return $this;
    }
    
    public function registerScript($name, $path, $deps = array(), $v = null, $global = false)
    {
        $this->registerAsset('wp_register_scripts', $name, $path, $deps, $v, $global);
        
        return $this;
    }
    
    public function registerStyles($config)
    {
        $this->registerAssets('wp_register_styles', $config);
        
        return $this;
    }
    
    public function registerStyle($name, $path, $deps = array(), $v = null, $global = false)
    {
        $this->registerAsset('wp_register_styles', $name, $path, $deps, $v, $global);
        
        return $this;
    }
    
    public function addGlobalScript($name)
    {
        if (!in_array($name, $this->global_assets)) {
            $this->global_assets[] = $name;
        }
        
        return $this;
    }
    
    public function addJSTemplates($config)
    {
        foreach ($config as $template) {
            list($name, $path) = $template;
            $this->addJSTemplate($name, $path);
        }
        
        return $this;
    }
    
    public function addJSTemplate($name, $path)
    {
        $this->js_templates[$name] = $path;
        
        return $this;
    }
    
    protected function registerAssets($var, $config)
    {
        foreach ($config as $style) {
            list($name, $path, $deps, $v, $global, $last_boolean) = array_pad($style, 6, null);
            $this->registerAsset($var, $name, $path, $deps, $v, $global, $last_boolean);
        }
    }
    
    protected function registerAsset($var, $name, $path, $deps = array(), $v = null, $global = false, $last_boolean = null)
    {
        if ($global) {
            $this->addGlobalScript($name);
        }
        
        $version = $v ? $v : $this->getVersion();
        
        $assets_array = &$this->$var;
        $assets_array[] = array(
            $this->prepareAssetName($name),
            $path,
            $this->prepareAssetsDeps($deps),
            $version,
            $last_boolean
        );
        
        $this->registerWPAssets();
    }
    
    public function registerWPAssets()
    {
        if (!did_action('wp_enqueue_scripts') && 
            !did_action('admin_enqueue_scripts')) {
            return;
        }
        
        while ($script = array_pop($this->wp_register_scripts) ) {
            list($name, $path, $deps, $v, $in_footer) = array_pad($script, 5, null);
            \wp_register_script($name, $path, $deps, $v, $in_footer);
        }
        
        while ($script = array_pop($this->wp_register_styles) ) {
            list($name, $path, $deps, $v, $media) = array_pad($script, 5, null);
            \wp_register_style($name, $path, $deps, $v, $media);
        }
        
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
            'rest_url' => \get_rest_url() . $this->getNamespace(),
            'ajax_url' => \admin_url('admin-ajax.php'),
        ), $this->getJSTemplatesContents());
    }
    
    public function getJSTemplatesContents()
    {
        $result = array();
        foreach ($this->js_templates as $name => $path) {
            if (strpos($path, 'http') !== false) {
                $result[$name] = \wp_remote_retrieve_body( \wp_remote_get($path) );
            } else if (@file_exists($path)) {
                $result[$name] = @file_get_contents($path);
            } else {
                continue;
            }
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
        if (!is_array($deps)) {
            $deps = array();
        }
        
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