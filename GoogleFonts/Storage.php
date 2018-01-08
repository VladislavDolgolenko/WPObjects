<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\GoogleFonts;

class Storage extends \WPObjects\Data\AbstractStorage implements
    GoogleApiKeyInterface
{
    protected $google_api_key = '';
    
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }
        
        $this->data = $this->getResponse();
        
        return $this->data;
    }
    
    function getResponse()
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