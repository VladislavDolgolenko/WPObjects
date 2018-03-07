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

namespace WPObjects\Session;

interface CookiesInterface
{
    public function setCookies(\WPObjects\Session\Cookies $Cookies);
    
    /**
     * @return \WPObjects\Session\Cookies
     */
    public function getCookies();
}