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

$system = include dirname(__FILE__) . '/services/system.php';
$model_factoris = include dirname(__FILE__) . '/services/model.factories.php';
$model_types = include dirname(__FILE__) . '/services/model.types.php';
$assets = include dirname(__FILE__) . '/services/assets.php';
$metaboxes = include dirname(__FILE__) . '/services/metaboxes.php';
$controllers = include dirname(__FILE__) . '/services/controllers.php';
$visual_composer_addons = include dirname(__FILE__) . '/services/visual-composer.addons.php';
$admin_pages = include dirname(__FILE__) . '/services/admin.pages.php';
$wpobjects = include dirname(__FILE__) . '/services/wpobjects.php';

return array_merge(
    $wpobjects,
    $admin_pages,
    $visual_composer_addons,
    $controllers, 
    $metaboxes, 
    $assets, 
    $model_types, 
    $model_factoris, 
    $system
);