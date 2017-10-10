<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

class AbstractDataModel extends AbstractData
{
    protected function initModel($post)
    {
        $class = $this->getModelType()->getModelClassName();
        return new $class($post, $this->getModelType());
    }
}