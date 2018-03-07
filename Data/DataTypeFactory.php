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

namespace WPObjects\Data;

use WPObjects\Factory\AbstractData;
use WPObjects\Data\DataType as DataTypeModel;

class DataTypeFactory extends AbstractData
{
    public function initModel($post)
    {
        $Model = new DataTypeModel($post);
        return $this->getServiceManager()->inject($Model);
    }
}