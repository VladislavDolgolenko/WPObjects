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
        'font-awesome',
        $assets_url . '/css/library/font-awesome.min.css',
        array(),
        null,
        true
    ),
    
    array(
        'selectize',
        $assets_url . '/css/library/selectize.css',
        array(),
        null,
        true
    ),

/**
 * UI
 */
    array(
        'bootstrap-wrapper',
        $assets_url . '/css/library/bootstrap-wrapper.css',
        array(),
    ),
    
    array(
        'helpers',
        $assets_url . '/css/helpers.css',
        array('bootstrap-wrapper', 'font-awesome', 'selectize'),
    ),
    
    array(
        'form',
        $assets_url . '/css/forms.css',
        array('bootstrap-wrapper', 'font-awesome', 'selectize', 'helpers'),
    ),
    
    array(
        'wp-customizer',
        $assets_url . '/css/wp-customizer.css',
        array(),
    ),
    
    array(
        'customizer-constroles',
        $assets_url . '/css/customizer-constroles.css',
        array('bootstrap-wrapper'),
    ),
    
/**
 * DataBase dashboard
 */
    
    array(
        'database',
        $assets_url . '/css/dashboard.css',
        array('bootstrap-wrapper', 'font-awesome'),
    ),
    
);
