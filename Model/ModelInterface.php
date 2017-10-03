<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

interface ModelInterface
{
    public function __construct($data);
    
    public function getId();
    
    public function getName();
    
    public function getMeta($key, $single = true);
    
    public function setMeta($key, $value, $prev = null);
    
    public function getModelType();
    
    public function save();
}