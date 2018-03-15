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
    
    /**
     * Will return params with font type 
     * 
     * @return \WPObjects\LessCompiler\ParamModel
     */
    public function getFontsParams()
    {
        return $this->query(array(
            'type' => 'font'
        ))->getResult();
    }
    
    /**
     * Using for generate and including link for uploading in page google fonts via api.
     * 
     * @return array
     */
    public function getUniqFontsNameAsArray()
    {
        $Fonts = $this->getFontsParams();
        
        $result = array();
        foreach ($Fonts as $Font) {
            if (!in_array($Font->getCurrentValue(), $result)) {
                $font_id = $Font->getCurrentValue();
                
                if (isset($Font->weights)) {
                    $weights = implode(',', $Font->weights);
                    $result[] = $font_id . ':' . $weights;
                } else {
                    $result[] = $font_id;
                }
            }
        }
        
        return $result;
    }
    
    public function getUrlForEnqueueGoogleFontsParams()
    {
        $fonts = $this->getUniqFontsNameAsArray();
        
        $font_url = '';
        /*
            Translators: If there are characters in your language that are not supported
            by chosen font(s), translate this to 'off'. Do not translate into your own language.
        */
        if ( 'off' !== _x( 'on', 'Google font: on or off', 'areathm' ) ) {
            $fonts_quary = implode('|', $fonts);
            
            $font_url = add_query_arg( 'family', $fonts_quary, "https://fonts.googleapis.com/css" );
        }

        return $font_url;
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