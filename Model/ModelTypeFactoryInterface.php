<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

interface ModelTypeFactoryInterface
{
    /**
     * @return \WPObjects\Model\ModelTypeFactory
     */
    public function getModelTypeFactory();
    
    public function setModelTypeFactory(\WPObjects\Model\ModelTypeFactory $ModelTypeFactory);
}