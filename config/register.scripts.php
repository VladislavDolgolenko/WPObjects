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

$assets_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets/custom';
$assets_url = plugin_dir_url($assets_path);

$SM = \WPObjects\Service\Manager::getInstance();
$google_api_key = $SM->get('google_api_key');

return array(
    
/**
 * Global
 */
    
    array(
        'selectize',
        $assets_url . '/js/library/selectize.js',
        array('jquery'),
        null,
        true
    ),

    array(
        'bootstrap',
        $assets_url . '/js/library/bootstrap.min.js',
        array('jquery'),
        '3.3.7',
        true
    ),
    
    array(
        'jquery.placepicker',
        $assets_url . '/js/library/jquery.placepicker.min.js',
        array('jquery', 'bootstrap', 'googleapis'),
        null,
        true
    ),
    
    array(
        'googleapis',
        'http://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&key=' . $google_api_key,
        array(),
        ''
    ),
    
/**
 * UI
 */
    
    array(
        'selectors',
        $assets_url . '/js/selectors.js',
        array('jquery', 'selectize'),
    ),

/**
 * Metaboxes
 */
    
    array(
        'metabox_attributes',
        $assets_url . '/js/attributes.js',
        array('backbone'),
    ),
    array(
        'metabox_image_picker',
        $assets_url . '/js/image-picker.js',
        array('jquery', 'backbone'),
    ),
    array(
        'metabox_gallery',
        $assets_url . '/js/gallery.js',
        array('jquery', 'backbone'),
    ),
    array(
        'location-picker',
        $assets_url . '/js/location-picker.js',
        array('jquery.placepicker'),
    ),
    
/**
 * DataBase dashboard
 */
    
    array(
        'model-data-type',
        $assets_url . '/js/MVC/model/data-type.js',
        array('backbone'),
    ),
    
    array(
        'collection-data-type',
        $assets_url . '/js/MVC/collection/data-type.js',
        array('backbone', 'model-data-type'),
    ),
    
    array(
        'view-dashboard-main-nav',
        $assets_url . '/js/MVC/view/dashboard/main-nav.js',
        array('backbone'),
    ),
    
    array(
        'view-dashboard-line',
        $assets_url . '/js/MVC/view/dashboard/line.js',
        array('backbone'),
    ),
    
    array(
        'view-dashboard-list',
        $assets_url . '/js/MVC/view/dashboard/list.js',
        array('backbone', 'view-dashboard-line'),
    ),
    
    array(
        'view-dashboard-filters',
        $assets_url . '/js/MVC/view/dashboard/filters.js',
        array('backbone'),
    ),
    
    array(
        'view-dashboard-field',
        $assets_url . '/js/MVC/view/dashboard/field.js',
        array('backbone'),
    ),
    
    array(
        'view-dashboard-form',
        $assets_url . '/js/MVC/view/dashboard/form.js',
        array('backbone', 'view-dashboard-field', 'bootstrap'),
    ),
    
    array(
        'view-dashboard',
        $assets_url . '/js/MVC/view/dashboard/dashboard.js',
        array(
            'backbone', 
            'view-dashboard-main-nav', 
            'collection-data-type', 
            'view-dashboard-list',
            'view-dashboard-filters',
            'view-dashboard-form'
        )
    ),
    
    array(
        'page-dashboard',
        $assets_url . '/js/page/dashboard.js',
        array('view-dashboard'),
    ),
    
    array(
        'customizer-presets-constrole-handler',
        $assets_url . '/js/customizer-presets-constrole-handler.js',
        array('backbone', 'jquery'),
        null,
        true,
        true
    ),
    
);