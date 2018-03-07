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
    
    'ModelTypeAttachment' => function ($sm) {
        return $sm->get('ModelTypeFactory')->get('attachment');
    },
    'ModelTypePost' => function ($sm) {
        return $sm->get('ModelTypeFactory')->get('post');
    },
    'ModelTypePage' => function ($sm) {
        return $sm->get('ModelTypeFactory')->get('page');
    },
    
);