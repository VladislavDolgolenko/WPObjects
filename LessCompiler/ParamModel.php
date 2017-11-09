<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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