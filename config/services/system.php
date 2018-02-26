<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    /**
     * System namespace
     * inject via DI interface WPObjects\Service\NamespaceInterface 
     */
    'namespace' => 'WPObjects',
    'build' => '1.0.0',
    'google_api_key' => '',
    
    'wpobjects_dir_path' => function () {
        return dirname( dirname( __DIR__ ) );
    },
    'plugin_dir_path' => '',
    'vc_addons_dir_path' => '',
    'vc_templates_dir_path' => '',
    
    /**
     * Dependence Injection Service
     * Configuration DI rules in service.di.php
     */
    'DI' => function ($sm) {
        $DI = new \WPObjects\Service\DI();
        $DI->addConfig( include $sm->get('wpobjects_dir_path') . '/config/service.di.php');
        return $DI;
    },
            
    /**
     * UserSession
     */
    'SessionStorage' => '\WPObjects\Session\Storage',
    'Cookies' => '\WPObjects\Session\Cookies',
            
    /**
     * Data Access Object
     */
    'DataAccess' => '\WPObjects\Data\Data',
            
    /**
     * Factory query filters listeners
     */
    'WordpressContextFilter' => '\WPObjects\Factory\FilterHendler\WordPressContext',
    'AggregatorFilter' => '\WPObjects\Factory\FilterHendler\Agregators',
            
    /**
     * Data storages
     */
    'PostTypeStorage' => function ($sm) {
        $data = new \WPObjects\Data\StorageCombine(array(
            'id' => 'post-type',
            'patches' => array(
                $sm->get('wpobjects_dir_path') . '/data/post-types.php'
            )
        ));
        
        return $data;
    },
            
    'DataTypeStorage' => function ($sm) {
        return new \WPObjects\Data\Storage(array(
            'id' => 'datas',
            'include' => $sm->get('wpobjects_dir_path') . '/data/data.php'
        ));
    },
    
);