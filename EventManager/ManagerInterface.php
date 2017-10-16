<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\EventManager;

interface ManagerInterface
{
    public function trigger($event);
    
    public function detachListener($event, $callable);
            
    public function attachListener($event, $callable);
    
    public function cleanListeners($event);
    
    public function detachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener);
    
    public function attachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener);
}