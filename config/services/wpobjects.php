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
    
    'wpobjects_build' => '1.1.4',
    
    'wpobjects_dir_path' => function () {
        return dirname( dirname( __DIR__ ) );
    },
    'wpobjects_dir_url' => function ($sm) {
        $path = $sm->get('wpobjects_dir_path');
        return plugin_dir_url($path . '/custom');
    },
    
    'wpobjects_copyright' => function($sm){
        return new \ArrayObject(array(
            'author' => 'Vladislav Dolgolenko',
            'author_link' => 'http://vladislavdolgolenko.com',
            'build' => $sm->get('wpobjects_build'),
            'wpobjects_link' => 'https://github.com/VladislavDolgolenko/WPObjects'
        )); 
    },
            
);