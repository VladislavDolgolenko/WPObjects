<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

$system = include dirname(__FILE__) . '/services/system.php';
$model_factoris = include dirname(__FILE__) . '/services/model.factories.php';
$model_types = include dirname(__FILE__) . '/services/model.types.php';
$assets = include dirname(__FILE__) . '/services/assets.php';
$metaboxes = include dirname(__FILE__) . '/services/metaboxes.php';
$controllers = include dirname(__FILE__) . '/services/controllers.php';
$visual_composer_addons = include dirname(__FILE__) . '/services/visual-composer.addons.php';
$admin_pages = include dirname(__FILE__) . '/services/admin.pages.php';

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