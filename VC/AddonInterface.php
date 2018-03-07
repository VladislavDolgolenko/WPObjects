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