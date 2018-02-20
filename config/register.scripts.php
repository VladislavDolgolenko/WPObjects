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
        'http://maps.googleapis.com/maps/api/js?sensor=true&libraries=places&key=AIzaSyDlacGPR94gjsCaIUqBPLHRLLG9h2AoO6A',
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
        'vc-addons-customizer-presets-constrole',
        $assets_url . '/js/vc-addons-customizer-presets-constrole.js',
        array('backbone', 'jquery'),
    ),
    
);