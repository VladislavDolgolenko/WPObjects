<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\PostType;

use WPObjects\Factory\AbstractData;
use WPObjects\PostType\PostType as PostTypeModel;

class PostTypeFactory extends AbstractData
{
    public function initModel($post)
    {
        $Model = new PostTypeModel($post);
        return $Model;
    }
}