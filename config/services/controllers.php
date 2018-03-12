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
    
    // !!!!!!!!!! not stored
    'TypicalModelRestController' => '\WPObjects\AjaxController\ModelController',
    
    'DataTypeRestController' => function ($sm) {
        $Controller = new \WPObjects\AjaxController\ModelController();
        $Controller->setObjectTypeName('data_type');
        $Controller->setFactory($sm->get('DataTypeFactory'));
        
        return $Controller;
    },
            
    'StorageRESTController' => '\WPObjects\Session\StorageRESTController',
            
    'UserSubscribeRegistrationListener' => '\WPObjects\User\Listeners\SubscribeRegistration',
    'PageAsArchiveForPostTypeListener' => '\WPObjects\PostType\Listeners\PageAsArchiveForPostType',
);