<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data\Dashboard;

class Page extends \WPObjects\Page\AdminPage
{
    protected $assets_dir_url = null;
    protected $assets_dir_path = null;
    
    public function __construct()
    {
        $this->setMenuName(__( 'Database', 'msp' ));
        $this->setTitle(__( 'Database', 'msp' ));
        $this->setPermission('manage_options');
        $this->setId('database');
        $this->setMenuPosition(30);
        
        $assets_dit_path = dirname(__FILE__) . '/assets';
        $this->setAssetsDirPath($assets_dit_path);
        $this->setAssetsDirUrl(plugin_dir_url($assets_dit_path . '/custom'));
        $this->setTemplatePath(dirname(__FILE__) . '/templates/dashboard.php');
    }
    
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        
        $AM->addGlobalScript('backbone')
           ->addGlobalScript('bootstrap')
           ->addGlobalScript('jquery')
           ->addGlobalScript('font-awesome');
        
        $AM->registerStyle('font-awesome', $this->getAssetsDirUrl() . '/' . 'css/library/font-awesome.min.css')
           ->registerStyle('bootstrap-wrapper', $this->getAssetsDirUrl() . '/' . 'css/library/bootstrap-wrapper.css')
           ->registerStyle('database', $this->getAssetsDirUrl() . '/' . 'css/dashboard.css', array('bootstrap-wrapper', 'font-awesome'));
        
        $AM->registerScript('bootstrap', $this->getAssetsDirUrl() . '/' . 'js/library/bootstrap.min.js', array('jquery'))
           ->registerScript('model-data-type', $this->getAssetsDirUrl() . '/' . 'js/MVC/model/data-type.js', array('backbone'))
           ->registerScript('collection-data-type', $this->getAssetsDirUrl() . '/' . 'js/MVC/collection/data-type.js', array('backbone', 'model-data-type'))
           ->registerScript('view-dashboard-main-nav', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/main-nav.js', array('backbone'))
           ->registerScript('view-dashboard-line', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/line.js', array('backbone'))
           ->registerScript('view-dashboard-list', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/list.js', array('backbone', 'view-dashboard-line'))
           ->registerScript('view-dashboard-filters', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/filters.js', array('backbone'))
           ->registerScript('view-dashboard-field', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/field.js', array('backbone'))
           ->registerScript('view-dashboard-form', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/form.js', array('backbone', 'view-dashboard-field', 'bootstrap'))
           ->registerScript('view-dashboard', $this->getAssetsDirUrl() . '/' . 'js/MVC/view/dashboard/dashboard.js', array(
                'backbone', 
                'view-dashboard-main-nav', 
                'collection-data-type', 
                'view-dashboard-list',
                'view-dashboard-filters',
                'view-dashboard-form'
            ))
           ->registerScript('page-dashboard', $this->getAssetsDirUrl() . '/' . '/js/page/dashboard.js', array('view-dashboard'));
        
        $AM->addJSTemplate('TmplDashboardMainNav', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/main-nav.html')
           ->addJSTemplate('TmplDashboardList', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/list.html')
           ->addJSTemplate('TmplDashboardLine', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/line.html')
           ->addJSTemplate('TmplDashboardFilters', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/filters.html')
           ->addJSTemplate('TmplDashboardForm', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/form.html')
           ->addJSTemplate('TmplDashboardField', $this->getAssetsDirPath() . DIRECTORY_SEPARATOR . 'js/MVC/template/dashboard/field.html');
        
        $AM->enqueueScript('page-dashboard');
        $AM->enqueueStyle('database');
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
}