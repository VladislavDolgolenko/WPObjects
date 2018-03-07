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