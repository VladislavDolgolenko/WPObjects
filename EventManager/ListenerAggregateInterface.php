<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\EventManager;

interface ListenerAggregateInterface
{
    public function attach(\WPObjects\EventManager\Manager $EventManager);
    
    public function detach(\WPObjects\EventManager\Manager $EventManager);
}