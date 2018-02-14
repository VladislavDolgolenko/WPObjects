<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    // !!!!!!!!!! not stored
    'TypicalModelRestController' => '\WPObjects\AjaxController\ModelController',
    
    'DataTypeRestController' => function ($sm) {
        $Controller = new \WPObjects\AjaxController\ModelController();
        $Controller->setObjectTypeName('data_type');
        $Controller->setFactory($sm->get('DataTypeFactory'));
        
        return $Controller;
    },
            
    'StorageRESTController' => '\WPObjects\Session\StorageRESTController',
);