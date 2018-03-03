<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(

    array(
        'id' => 'attachment',
        'model_class_name' => '\WPObjects\WPModel\Attachment',
        'qualifiers' => array(),
        'register_metas' => array(),
        'MetaBoxes' => array(),
        'factory_service_name' => 'AttachmentsFactory',
        'config' => array()
    ),
    
    array(
        'id' => 'post',
        'model_class_name' => '\WPObjects\WPModel\Post',
        'qualifiers' => array(),
        'register_metas' => array(),
        'MetaBoxes' => array(),
        'factory_service_name' => 'PostsFactory',
        'config' => array ()
    ),
    
    array(
        'id' => 'page',
        'model_class_name' => '\WPObjects\WPModel\Page',
        'qualifiers' => array(),
        'register_metas' => array(),
        'factory_service_name' => 'PageFactory',
        'config' => array ()
    ),
    
);