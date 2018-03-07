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

namespace WPObjects\Model;

use WPObjects\Factory\FactoriesAggregator;

class ModelTypeFactory extends FactoriesAggregator
{
    public function getAgregators(\WPObjects\Model\AbstractModelType $ModelType)
    {
        return $this->query(array(
            'qualifiers' => $ModelType->getId()
        ));
    }
    
    public function getAgregator(\WPObjects\Model\AbstractModelType $ModelType, $agregator_id)
    {
        return $this->query(array(
            'id' => $agregator_id,
            'qualifiers' => $ModelType->getId()
        ));
    }
}