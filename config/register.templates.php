<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

$assets_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets/custom';
$assets_url = plugin_dir_url($assets_path);

return array(
    
/**
 * DataBase dashboard
 */
    
    array(
        'TmplDashboardMainNav',
        $assets_url . '/js/MVC/template/dashboard/main-nav.html'
    ),
    
    array(
        'TmplDashboardList',
        $assets_url . '/js/MVC/template/dashboard/list.html'
    ),
    
    array(
        'TmplDashboardLine',
        $assets_url . '/js/MVC/template/dashboard/line.html'
    ),
    
    array(
        'TmplDashboardFilters',
        $assets_url . '/js/MVC/template/dashboard/filters.html'
    ),
    
    array(
        'TmplDashboardForm',
        $assets_url . '/js/MVC/template/dashboard/form.html'
    ),
    
    array(
        'TmplDashboardField',
        $assets_url . '/js/MVC/template/dashboard/field.html'
    ),
    
);