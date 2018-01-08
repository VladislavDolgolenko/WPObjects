<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\GoogleFonts;

class FontsFactory extends \WPObjects\Factory\AbstractDataModel
{
    public function getByCategory($category)
    {
        return $this->query(array(
            'category' => $category
        ))->getResult();
    }
}