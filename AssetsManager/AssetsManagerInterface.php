<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\AssetsManager;

interface AssetsManagerInterface
{
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM);
    
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager();
}