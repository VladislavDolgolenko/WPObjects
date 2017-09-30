<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

interface FactoryInrerface
{
    public function get($id);

    public function query($filters = array(), $result_as_object = false);
    
    public function prepareMetaValue($value);
    
    public function getResult();
    
    public function getSpecializationAttrName($type);
    
    public function getModelType();
}

