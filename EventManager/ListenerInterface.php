<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\EventManager;

/**
 * Default listener aggregator interface
 * Using for attach listeners to WordPress actions
 */
interface ListenerInterface
{
    public function attach();
    
    public function detach();
}