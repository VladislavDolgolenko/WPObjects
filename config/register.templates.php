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
    
/**
 * MetaBoxes
 */
    
    array(
        'TmplAttachmentFilesList',
        $assets_path . '/js/MVC/template/meta-boxes/attachment-files/list.html'
    ),
    
    array(
        'TmplAttachmentFilesFile',
        $assets_path . '/js/MVC/template/meta-boxes/attachment-files/file.html'
    ),
    
);