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

interface ManagerInterface
{
    public function trigger($event);
    
    public function detachListener($event, $callable);
            
    public function attachListener($event, $callable);
    
    public function cleanListeners($event);
    
    public function detachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener);
    
    public function attachListenersAggregator(\WPObjects\EventManager\ListenerAggregateInterface $Listener);
}