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

return array(
    
    /**
     * System namespace
     * inject via DI interface WPObjects\Service\NamespaceInterface 
     */
    'namespace' => 'WPObjects',
    'build' => '1.0.0',
    'plugin_dir_path' => '',
    'vc_addons_dir_path' => '',
    'vc_templates_dir_path' => '',
    
    'google_api_key' => function($sm){
        return $sm->get('SettingsFactory')->getValue('google_api_key');
    },
    
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
                $sm->get('wpobjects_dir_path') . '/storage/post-types.php'
            )
        ));
        
        return $data;
    },
            
    'DataTypeStorage' => function ($sm) {
        return new \WPObjects\Data\Storage(array(
            'id' => 'datas',
            'include' => $sm->get('wpobjects_dir_path') . '/storage/data.php'
        ));
    },
            
    'SettingsStorage' => function ($sm) {
        return new WPObjects\Data\Storage(array(
            'id' => 'settings',
            'include' => $sm->get('wpobjects_dir_path') . '/storage/settings.php'
        ));
    },
    
);