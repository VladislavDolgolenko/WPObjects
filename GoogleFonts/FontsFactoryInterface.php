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

namespace WPObjects\GoogleFonts;

interface FontsFactoryInterface
{
    public function setFontsFactory(\WPObjects\GoogleFonts\FontsFactory $FontsFactory);
    
    /**
     * @return \WPObjects\GoogleFonts\FontsFactory
     */
    public function getFontsFactory();
}