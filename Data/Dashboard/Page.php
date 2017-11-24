<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data\Dashboard;

class Page extends \WPObjects\Page\AdminPage implements
    \WPObjects\Service\NamespaceInterface
{
    protected $namespace = '';
    protected $assets_version = null;
    protected $global_assets = array();
    protected $template_path = null;
    protected $assets_dir_url = null;
    protected $assets_dir_path = null;
    
    public function __construct()
    {
        $this->setMenuName(__( 'Database', 'msp' ));
        $this->setTitle(__( 'Database', 'msp' ));
        $this->setPermission('manage_options');
        $this->setId($this->getNamespace() . 'database');
        $this->setMenuPosition(30);
        
        $this->global_assets = array('backbone', 'bootstrap', 'jquery', 'font-awesome');
        $this->setAssetsVersion('1.0.0');
    }
    
    public function enqueues()
    {
        $this->enqueueCSS('font-awesome', 'css/library/font-awesome.min.css');
        $this->enqueueCSS('bootstrap-wrapper', 'css/library/bootstrap-wrapper.css');
        $this->enqueueCSS('database', 'css/dashboard.css', array('bootstrap-wrapper', 'font-awesome'));
        
        wp_enqueue_script('backbone');
        wp_localize_script('backbone', 'MSP', $this->getJSObject());
        
        $this->enqueueJS('bootstrap', 'js/library/bootstrap.min.js', array('jquery'));
        $this->enqueueJS('model-data-type', 'js/MVC/model/data-type.js', array('backbone'));
        $this->enqueueJS('collection-data-type', 'js/MVC/collection/data-type.js', array('backbone', 'model-data-type'));
        $this->enqueueJS('view-dashboard-main-nav', 'js/MVC/view/dashboard/main-nav.js', array('backbone'));
        $this->enqueueJS('view-dashboard-line', 'js/MVC/view/dashboard/line.js', array('backbone'));
        $this->enqueueJS('view-dashboard-list', 'js/MVC/view/dashboard/list.js', array('backbone', 'view-dashboard-line'));
        $this->enqueueJS('view-dashboard-filters', 'js/MVC/view/dashboard/filters.js', array('backbone'));
        $this->enqueueJS('view-dashboard-field', 'js/MVC/view/dashboard/field.js', array('backbone'));
        $this->enqueueJS('view-dashboard-form', 'js/MVC/view/dashboard/form.js', array('backbone', 'view-dashboard-field', 'bootstrap'));
        $this->enqueueJS('view-dashboard', 'js/MVC/view/dashboard/dashboard.js', array(
            'backbone', 
            'view-dashboard-main-nav', 
            'collection-data-type', 
            'view-dashboard-list',
            'view-dashboard-filters',
            'view-dashboard-form'
        ));
        
        $this->enqueueJS('page-dashboard', '/js/page/dashboard.js', array('view-dashboard'));
    }
    
    public function getJSObject()
    {
        return array_merge(array(
            'nonce' => \wp_create_nonce('wp_rest'),
            'rest_url' => \get_rest_url() . $this->getNamespace()
        ), $this->getJSTemplates());
    }
    
    public function getJSTemplates()
    {
        $result = array();
        $result['TmplDashboardMainNav'] = $this->getAssetContent('js/MVC/template/dashboard/main-nav.html');
        $result['TmplDashboardList'] = $this->getAssetContent('js/MVC/template/dashboard/list.html');
        $result['TmplDashboardLine'] = $this->getAssetContent('js/MVC/template/dashboard/line.html');
        $result['TmplDashboardFilters'] = $this->getAssetContent('js/MVC/template/dashboard/filters.html');
        $result['TmplDashboardForm'] = $this->getAssetContent('js/MVC/template/dashboard/form.html');
        $result['TmplDashboardField'] = $this->getAssetContent('js/MVC/template/dashboard/field.html');
        
        return $result;
    }
    
    public function enqueueCSS($script_name, $assets_path = null, $deps = array())
    {
        if ($assets_path) {
            wp_enqueue_style($this->prepareAssetName($script_name), $this->getAssetsDirUrl() . '/' . $assets_path, $this->prepareAssetsDeps($deps), $this->getAssetsVersion());
        } else {
            wp_enqueue_style($this->prepareAssetName($script_name));
        }
    }
    
    public function enqueueJS($script_name, $assets_path = null, $deps = array())
    {
        if ($assets_path) {
            wp_enqueue_script($this->prepareAssetName($script_name), $this->getAssetsDirUrl() . '/' . $assets_path, $this->prepareAssetsDeps($deps), $this->getAssetsVersion());
        } else {
            wp_enqueue_script($this->prepareAssetName($script_name));
        }
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
    
    public function getAssetContent($asset_path)
    {
        return file_get_contents( $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . $asset_path );
    }
    
    public function getAssetsDirUrl()
    {
        return $this->assets_dir_url;
    }
    
    public function setAssetsDirUrl($string)
    {
        $this->assets_dir_url = $string;
    }
    
    public function getAssetsDirPath()
    {
        return $this->assets_dir_path;
    }
    
    public function setAssetsDirPath($string)
    {
        $this->assets_dir_path = $string;
    }
    
    public function getTemplatePath()
    {
        return $this->template_path;
    }
    
    public function setTemplatePath($string)
    {
        $this->template_path = $string;
    }
    
    public function setNamespace($string)
    {
        $this->namespace = $string;
    }
    
    public function getNamespace()
    {
        return $this->namespace;
    }
    
    public function setAssetsVersion($string)
    {
        $this->assets_version = $string;
    }
    
    public function getAssetsVersion()
    {
        return $this->assets_version;
    }
}