<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

use WPObjects\Factory\AbstractFactory;

abstract class AbstractModel implements ModelInterface
{
    protected $model_type = null;
    
    /**
     * @param AbstractFactory $Factory
     * @return \WPObjects\Model\AbstractModel || array
     */
    protected function getRelative(\WPObjects\Factory\AbstractFactory $Factory)
    {
        $model_type_id = $Factory->getModelType();
        if (isset($this->relatives[$model_type_id])) {
            return $this->relatives[$model_type_id];
        }
        
        $attr = AbstractFactory::getSpecializationAttrName($model_type_id);
        $relative_model_id = $this->getMeta($attr);
        if (!$relative_model_id) {
            return null;
        }
        
        $Model = $Factory->get($relative_model_id);
        $this->relatives[$model_type_id] = $Model;
        return $Model;
    }
}

