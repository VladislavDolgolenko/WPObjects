<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

interface StorageInterface
{
    /**
     * @return \WPObjects\Data\Storage
     */
    public function getStorage();
    
    public function setStorage(\WPObjects\Data\AbstractStorage $Storage);
}