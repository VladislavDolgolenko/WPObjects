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

namespace WPObjects\EventManager;

interface ListenerAggregateInterface
{
    public function attach(\WPObjects\EventManager\Manager $EventManager);
    
    public function detach(\WPObjects\EventManager\Manager $EventManager);
}