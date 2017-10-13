<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
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
}