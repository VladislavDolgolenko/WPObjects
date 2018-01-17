<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace AREA;

return array(
    
    'AttachmentsFactory' => '\WPObjects\WPFactory\Attachment',
    'PostsFactory' => '\WPObjects\WPFactory\Post',
        
    'ModelTypeAttachment' => function ($sm) {
        return $sm->get('ModelTypeFactory')->get('attachment');
    },
    'ModelTypePost' => function ($sm) {
        return $sm->get('ModelTypeFactory')->get('post');
    },
            
    'ModelTypeFactory' => '\WPObjects\Model\ModelTypeFactory',

);