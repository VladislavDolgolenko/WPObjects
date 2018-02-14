<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

$system = include 'services/system.php';
$model_factoris = include 'services/model.factories.php';
$model_types = include 'services/model.types.php';
$assets = include 'services/assets.php';
$metaboxes = include 'services/metaboxes.php';
$controllers = include 'services/controllers.php';
$visual_composer_addons = include 'services/visual-composer.addons.php';
$admin_pages = include 'services/admin.pages.php';

return array_merge(
    $admin_pages,
    $visual_composer_addons,
    $controllers, 
    $metaboxes, 
    $assets, 
    $model_types, 
    $model_factoris, 
    $system
);