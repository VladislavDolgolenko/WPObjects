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

namespace WPObjects\LessCompiler;

interface WPlessInterface
{
    /**
     * @return \WPObjects\LessCompiler\WPless
     */
    public function getWPLess();
    
    public function setWPLess(\WPObjects\LessCompiler\WPless $WPless);
}