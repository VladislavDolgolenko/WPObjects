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

namespace WPObjects\Data;

interface DataAccessInterface
{
    public function setDataAccess(\WPObjects\Data\Data $Data);
    
    /**
     * @return \WPObjects\Data\Data
     */
    public function getDataAccess();
}