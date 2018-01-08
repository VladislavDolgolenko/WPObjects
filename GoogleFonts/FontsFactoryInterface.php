<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\GoogleFonts;

interface FontsFactoryInterface
{
    public function setFontsFactory(\WPObjects\GoogleFonts\FontsFactory $FontsFactory);
    
    /**
     * @return \WPObjects\GoogleFonts\FontsFactory
     */
    public function getFontsFactory();
}