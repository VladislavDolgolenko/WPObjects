<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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
);