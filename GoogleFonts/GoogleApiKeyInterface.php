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

interface GoogleApiKeyInterface
{
    /**
     * Set google api key
     * 
     * @param string $string
     */
    public function setGoogleApiKey($string);
    
    public function getGoogleApiKey();
}