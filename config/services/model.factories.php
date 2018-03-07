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
    
    'AttachmentsFactory' => '\WPObjects\WPFactory\Attachment',
    'PostsFactory' => '\WPObjects\WPFactory\Post',
    'PageFactory' => '\WPObjects\WPFactory\Page',
    'ModelTypeFactory' => '\WPObjects\Model\ModelTypeFactory',
    
    'PostTypeFactory' => '\WPObjects\PostType\PostTypeFactory',
    'DataTypeFactory' => '\WPObjects\Data\DataTypeFactory',
    
    'PostTypeManager' => function ($sm) {
        return new \WPObjects\PostType\Manager($sm->get('PostTypeFactory'));
    },
            
    'SettingsFactory' => '\WPObjects\Settings\Factory',
    
);