<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

$assets_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets';

return array(
    
/**
 * DataBase dashboard
 */
    
    array(
        'TmplDashboardMainNav',
        $assets_path . '/js/MVC/template/dashboard/main-nav.html'
    ),
    
    array(
        'TmplDashboardList',
        $assets_path . '/js/MVC/template/dashboard/list.html'
    ),
    
    array(
        'TmplDashboardLine',
        $assets_path . '/js/MVC/template/dashboard/line.html'
    ),
    
    array(
        'TmplDashboardFilters',
        $assets_path . '/js/MVC/template/dashboard/filters.html'
    ),
    
    array(
        'TmplDashboardForm',
        $assets_path . '/js/MVC/template/dashboard/form.html'
    ),
    
    array(
        'TmplDashboardField',
        $assets_path . '/js/MVC/template/dashboard/field.html'
    ),
    
);