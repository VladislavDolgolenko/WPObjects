<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace MSP\MetaBox;

use MSP\WPObjects\PostType\MetaBox;

abstract class AbstractMetaBox extends MetaBox
{
    public function __construct()
    {
        
    }
    
    /**
     * @var \WPObjects\Model\AbstractPostModel
     */
    protected $PostModel = null;
    
    /**
     * @return \WPObjects\Model\AbstractPostModel
     */
    protected function getPostModel()
    {
        if (is_null($this->PostModel) && $this->getPost()) {
            $PostType = $this->getPostType();
            $this->PostModel = $PostType->createModel($this->getPost());
        }
        
        return $this->PostModel;
    }
    
    /**
     * @return \WPObjects\PostType\PostType
     */
    protected function getPostType()
    {
        $Factory = $this->getServiceManager()->get('PostTypeFactory');
        return $Factory->get($this->getPost()->post_type);
    }
    
    public function getTemplatePath()
    {
        return MSP_PATH . 'includes/templates/meta-box/' . $this->getId()  . '.php';
    }
    
    public function enqueues()
    {
        wp_enqueue_style('msp-forms');
        wp_enqueue_style('selectize');
        
        wp_enqueue_script('msp_metabox_selectors');
    }
    
    public function renderQualifierSelector($model_type_id, $lable, $vertical = true, $desctiption = "", $multibple = false, $qualifier = null, $array_result = false)
    {
        $Factory = $this->getServiceManager()->get('ModelTypeFactory');
        $ModelType = $Factory->get($model_type_id);
        $Game = $this->getGame();
        
        $options_filters = array();
        if ($Game && $ModelType->hasQualifier(\MSP\DataType\ModelType::GAME)) {
            $filter_name = $ModelType->getQualifierAttrName(\MSP\DataType\ModelType::GAME);
            $options_filters[$filter_name] = $Game->getId();
        }
        
        $Models = $ModelType->getFactory()->query($options_filters)->getResult();
        
        $options = array();
        foreach ($Models as $Model) {
            $options[] = array(
                'id' => $Model->getId(),
                'name' => $Model->getName(),
                'img' => $Model->getImgForSelect()
            );
        }
        
        $lable = $lable ? $lable : $ModelType->getName();
        $name = $qualifier === null ? $this->getPostType()->getQualifierAttrName($model_type_id) : $qualifier;
        $selected = $this->getPostModel()->getMeta($name);
        if (!is_array($selected)) {
            $selected = array($selected);
        }
        
        if ($ModelType instanceof \MSP\WPObjects\PostType\PostType) {
            $add_new_link = $ModelType->getAddNewLink();
            $add_new_text = $ModelType->getLabels('add_new_item');                     
        } else {
            $add_new_link = $this->getAddNewEntryLink();
            $add_new_text = __('Add new entry to') . ' ' . $ModelType->getName();
        }
        
        include $this->getPartTemplatePath('selector');
    }
    
    public function renderCustomInput($meta_attr_name, $lable, $vertical = true, $desctiption = "", $type = 'text', $step = "", $invert_with = false, $balance_with = false)
    {
        $value = $this->getPostModel()->getMeta($meta_attr_name);
        include $this->getPartTemplatePath('custom-input');
    }
    
    public function renderCustomCheckbox($meta_attr_name, $lable, $vertical = true, $desctiption = "")
    {
        $meta_value = $this->getPostModel()->getMeta($meta_attr_name) ;
        $value = $meta_value ? true : false;
        
        include $this->getPartTemplatePath('checkbox');
    }
    
    public function renderDateTimeInput($meta_time_attr, $lable, $vertical = true, $desctiption = "")
    {
        $meta_value = $this->getPostModel()->getMeta($meta_time_attr);
        $date_parts = explode(' ', $meta_value);
        $date = isset($date_parts[0]) ? $date_parts[0] : '';
        $time = isset($date_parts[1]) ? $date_parts[1] : '';
        
        $date_attr = $meta_time_attr . '_date';
        $time_attr = $meta_time_attr . '_time';
        
        include $this->getPartTemplatePath('datetime');
    }
    
    public function getAddNewEntryLink()
    {
        $DashboardPage = $this->getServiceManager()->get('MultiSportPage');
        return $DashboardPage->getUrl();
    }
    
    public function getPartTemplatePath($name)
    {
        return MSP_PATH . 'includes/templates/meta-box/template-parts/' . $name  . '.php';
    }
    
    public function getGame()
    {
        $Model = $this->getPostModel();
        $ModelType = $Model->getModelType();
        if (!$ModelType->hasQualifier(\MSP\DataType\ModelType::GAME)) {
            return false;
        }
        
        return $Model->getRelative(\MSP\DataType\ModelType::GAME);
    }
}