<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

interface AddonInterface
{
    /**
     * @param \WPObjects\VC\CustomAddonModel $Addon
     */
    public function setAddon(\WPObjects\VC\CustomAddonModel $Addon);
    
    /**
     * @return \WPObjects\VC\CustomAddonModel
     */
    public function getAddon();
    
}