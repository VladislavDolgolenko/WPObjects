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

class Storage extends \WPObjects\Data\AbstractStorage implements
    GoogleApiKeyInterface
{
    protected $google_api_key = '';
    
    public function readStorage()
    {
        if (!$this->getGoogleApiKey()) {
            return array();
        }
        
        $request = @file_get_contents('https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=' . $this->getGoogleApiKey());
        if (!$request) {
            return array();
        }

        $result_array = json_decode($request, true);
        $fonts_list = isset($result_array['items']) ? $result_array['items'] : array();

        return $fonts_list;
    }
    
    public function setGoogleApiKey($string)
    {
        $this->google_api_key = $string;
        
        return $this;
    }
    
    public function getGoogleApiKey()
    {
        return $this->google_api_key;
    }
}