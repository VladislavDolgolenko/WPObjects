<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
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