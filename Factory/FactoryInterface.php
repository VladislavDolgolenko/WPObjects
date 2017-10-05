<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

interface FactoryInterface
{
    public function get($id = null, $filters = array(), $single = true);

    public function query($filters = array(), $result_as_object = false);
    
    static public function prepareMetaValue($value);
    
    public function getResult();
    
    public function initModel($post);
    
    static public function getSpecializationAttrName($type);
    
    public function getModelType();
}

