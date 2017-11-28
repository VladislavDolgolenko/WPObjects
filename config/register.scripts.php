<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

$assets_path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets/custom';
$assets_url = plugin_dir_url($assets_path);

return array(
    
    array(
        'selectize',
        $assets_url . '/js/library/selectize.js',
        array('jquery'),
        null,
        true
    ),
    
    array(
        'selectors',
        $assets_url . '/js/selectors.js',
        array('jquery', 'selectize'),
    ),
);