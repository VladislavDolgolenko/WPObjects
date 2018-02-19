<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

use WPObjects\Factory\AbstractData;

class ParamsFactory extends AbstractData
{
    protected $result_as_theme_mode_defaults = null;
    
    public function initModel($post)
    {
        $ParamModel =  new ParamModel($post, \ArrayObject::ARRAY_AS_PROPS);
        $this->getServiceManager()->inject($ParamModel);
        return $ParamModel;
    }
    
    public function getByGroup($group)
    {
        $this->query(array(
            'group' => $group
        ));
        
        return $this->getResult();
    }
    
    public function getResultGroupped()
    {
        $colors = $this->getResult();

        $groups = array();
        foreach ($colors as $name => $color) {
            $group = isset($color['group']) ? $color['group'] : 'other';
            if (!isset($groups[$group])) {
                $groups[$group] = array();
            }

            $groups[$group][$name] = $color;
        }

        return $groups;
    }
    
    public function getParamValueById($id)
    {
        $Param = $this->get($id);
        if ($Param) {
            return null;
        }
        
        return $Param->getCurrentValue();
    }
    
    public function getResultAsLessParams()
    {
        $Params = $this->getResult();
        
        $result = array();
        foreach ($Params as $Param) {
            $result[$Param->getId()] = $Param->getCurrentValue();
        }
        
        return $result;
    }
    
    public function getResultAsThemeModeDefault()
    {
        $Params = $this->getResult();
        
        $result = array();
        foreach ($Params as $Param) {
            $object = $Param->getArrayCopy();
            $object['default'] = $Param->getCurrentValue();
            $object['label'] = $Param->get('label');
            $result[$Param->getId()] = $object;
        }
        
        return $result;
    }
}