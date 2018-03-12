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

namespace WPObjects\WPFactory;

class Attachment extends \WPObjects\Factory\AbstractPostModel 
{
    protected function buildSpecialMetaQuery()
    {
        $this->query['post_status'] = 'inherit';
    }
}