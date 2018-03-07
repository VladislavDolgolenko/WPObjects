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

namespace WPObjects\VC\Shortcode;

interface ShortcodeInterface
{
    /**
     * @param \WPBakeryShortCode $Shortcode
     */
    public function setShortcode(\WPBakeryShortCode $Shortcode);
    
    /**
     * @return \WPBakeryShortCode 
     */
    public function getShortcode();
}