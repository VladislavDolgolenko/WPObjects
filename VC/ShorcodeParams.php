<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC;

/**
 * @since 3.0.9
 */
class ShorcodeParams
{
    function genAllParams(\WPObjects\Model\AbstractModelType $ModelType, $before = array(), $after = array())
    {
        $model_type_filters = $ModelType->getFactory()->getSpecialQueryParamsForVCAddons();
        $before = array_merge($before, $model_type_filters);
        
        return array_merge(
            $this->genPageContextParam($ModelType),
            $this->genOrderingParams($ModelType),
            $before,
            $this->genFiltersForModelType($ModelType), 
            $after
        );
    }
    
    /**
     * Generate filters query params for model type, 
     * this params using in shortcode template for 
     * building query for typical model via factory.
     * 
     * @param \WPObjects\Model\AbstractModelType $ModelType
     * @return array with VC shorcode valid params
     */
    function genFiltersForModelType(\WPObjects\Model\AbstractModelType $ModelType)
    {
        /* @var $ContextModelType \WPObjects\Model\AbstractModelType */
        $params_group = $this->getParamsGroup($ModelType->getName());
        $result = array();
        
        $ModelTypeFactory = $ModelType->getModelTypeFactory();
        $model_types_ids = $ModelType->getContextModelTypes();

        /* Filter by current model type objects */
        $values = $ModelType->getFactory()->query()->getForVCAutocompele();
        $heading = __('Select target ', 'msp') . ' ' . $ModelType->getName();
        $result[] = $this->genFilter($heading, 'id', $params_group, $values);
        
        /* Filter by context model type objects of current */
        
        foreach ($model_types_ids as $model_type_id) {
            if ($model_type_id === $ModelType->getId()) {
                continue;
            }
            
            $ContextModelType = $ModelTypeFactory->get($model_type_id);
            $values = $ContextModelType->getFactory()->query()->getForVCAutocompele();
            $param_name = $ModelType->getQualifierAttrName($ContextModelType->getId());
            $heading = __('Filter by', 'msp') . ' ' . $ContextModelType->getName();
            
            $result[] = $this->genFilter($heading, $param_name, $params_group, $values);
        }
        
        return $result;
    }
    
    function genFilter($heading, $param_name, $params_group, $values)
    {
        return array(
            'type' => 'autocomplete',
            'heading' => $heading,
            'param_name' => $param_name,
            'group' => $params_group,
            'settings' => array(
                'multiple' => true,
                'unique_values' => true,
                'display_inline' => true,
                'delay' => 300,
                'sortable' => true,
                'groups' => true,
                'auto_focus' => true,
                'values' => $values
            ),
        );
    }
    
    function genPageContextParam(\WPObjects\Model\AbstractModelType $ModelType, $default = true)
    {
        $result = array();
        $heading = sprintf(__('Quared %s by current page context?', 'msp' ), $ModelType->getName());
        $description = sprintf(__('This magic option, it make %s query filter сonsidering current page context.', 'msp'), $ModelType->getName());
        $params_group = $this->getParamsGroup($ModelType->getName());
        
        $result[] = array(
            'type' => 'checkbox',
            'heading' => $heading,
            'description' => $description,
            'param_name' => 'page_context',
            'group' => $params_group,
            'value' => array(
                __( 'Yes', 'msp' ) => 'yes',
            ),
            'std' => $default ? 'yes' : null
        );
        
        return $result;
    }
    
    function genOrderingParams(\WPObjects\Model\AbstractModelType $ModelType, $special_ordering = array())
    {
        $result = array();
        $mata_datas = $ModelType->get('register_metas');
        $params_group = $this->getParamsGroup($ModelType->getName());
        
        $values = array(
            __('Not sort', 'msp') => 'none',
            __('Date publ', 'msp') => 'date',
            __('Title (name)', 'msp') => 'name',
            __('Random', 'msp') => 'rand',
        );
        
        foreach ($mata_datas as $meta_data) {
            if (strpos($meta_data, '*') !== false || strpos($meta_data, '_id') !== false) {
                continue;
            }
            
            $orderby_name = ucfirst( strtolower(str_replace(array('_'), ' ', $meta_data)) );
            $values[$orderby_name] = $meta_data;
        }
        
        $model_type_sorting = $ModelType->getFactory()->getSpecialSortingTypesForVCAddons();
        $values = array_merge($values, $special_ordering, $model_type_sorting);
        
        $result[] = array(
            'type' => "dropdown",
            'heading' => __('Sorted by', 'msp'),
            'description' => __('Perhaps not all of these attributes are suitable for sorting', 'msp'),
            'param_name' => 'orderby',
            'group' => $params_group,
            'value' => $values
        );
        
        $result[] = array(
            'type' => 'dropdown',
            'heading' => __( 'Order', 'msp' ),
            'description' => __( 'DESC: 3, 2, 1, ASC: 1, 2, 3.', 'msp'),
            'param_name' => 'order',
            'group' => $params_group,
            'value' => array(
                'ASC' => 'ASC',
                'DESC' => 'DESC',
            )
        );
        
        $result[] = array(
            'type' => 'textfield',
            'holder' => 'div',
            'heading' => __('Max results count', 'msp'),
            'description' => __('* This option not workable with pagination', 'msp'),
            'param_name' => 'numberposts',
            'group' => $params_group,
            'value' => 5,
        );
        
        return $result;
    }
    
    function getParamsGroup($model_type_name)
    {
        return $model_type_name . ' ' . __('query', 'msp') ;
    }
}
