<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\View\UI;

abstract class AbstractUI extends \WPObjects\View\View
{
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        
        $AM->enqueueStyle('form')
           ->enqueueScript('selectors');
        
        return $this;
    }
}