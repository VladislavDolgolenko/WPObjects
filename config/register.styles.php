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
$LessParamsFactory = $SM->get('LessCompileParamsFactory');
$google_fonts_url = $LessParamsFactory->getUrlForEnqueueGoogleFontsParams();

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
 * Fonts
 */
    array(
        'googlefonts',
        $google_fonts_url,
        array(),
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
