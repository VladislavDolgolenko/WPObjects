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