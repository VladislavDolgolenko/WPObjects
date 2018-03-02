<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\PostType\MetaBox;

use WPObjects\PostType\MetaBox;

abstract class AbstractMetaBox extends MetaBox
{
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        $AM->enqueueStyle('form');
    }
    
    public function processing(\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        return $data;
    }
    
    public function renderQualifierSelector($model_type_id, $multiple = false, $vertical = true, $qualifier = '', $array_result = false)
    {
        $Selector = $this->initQualifierSelector();
        $Selector->setModelTypeId($model_type_id)
                 ->setVertical($vertical)
                 ->setQualifier($qualifier)
                 ->setArrayResult($array_result)
                 ->setMultiple($multiple)
                 ->setModel($this->getPostModel());
        
        $Selector->render();
    }
    
    /**
     * @return \WPObjects\View\UI\QualifierSelector
     */
    public function initQualifierSelector()
    {
        return $this->getServiceManager()->inject(new \WPObjects\View\UI\QualifierSelector());
    }
    
    public function renderSelector($attr_name, $label, $options, $vertical = true, $multiple = false)
    {
        $Selector = $this->initSelector();
        
        $Selector->setName($attr_name)
                 ->setSelected( $this->getPostModel()->getMeta($attr_name) )
                 ->setVertical($vertical)
                 ->setLable($label)
                 ->setMultiple($multiple)
                 ->setOptions($options);
        
        $Selector->render();
    }
    
    public function renderCheckbox($attr_name, $lable, $vestical = true)
    {
        $Checkbox = $this->initCheckbox();
        
        $Checkbox->setName($attr_name)
                 ->setValue( $this->getPostModel()->getMeta($attr_name))
                 ->setVertical($vestical)
                 ->setLable($lable);
        
        $Checkbox->render();
    }
    
    /**
     * @return \WPObjects\View\UI\Checkbox
     */
    public function initCheckbox()
    {
        return $this->getServiceManager()->inject(new \WPObjects\View\UI\Checkbox());
    }
    
    /**
     * @return \WPObjects\View\UI\Selector
     */
    public function initSelector()
    {
        return $this->getServiceManager()->inject(new \WPObjects\View\UI\Selector());
    }

    public function renderAttrInput($attr_name, $lable, $vestical = true, $type = 'text')
    {
        $Input = $this->initInput();
        $Input->setName($attr_name);
        $Input->setValue( $this->getPostModel()->getMeta($attr_name));
        $Input->setVertical($vestical);
        $Input->setLable($lable);
        $Input->setType($type);
        
        $Input->render();
    }
    
    /**
     * @return \WPObjects\View\UI\Input
     */
    public function initInput()
    {
        return $this->getServiceManager()->inject(new \WPObjects\View\UI\Input());
    }
}