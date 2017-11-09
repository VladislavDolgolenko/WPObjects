<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\LessCompiler;

class ParamModel extends \ArrayObject
{
    public function getCurrentValue()
    {
        $setting_name = 'mdl__color_' . $this->id;
        return \get_theme_mod($setting_name, $this->default);
    }
}