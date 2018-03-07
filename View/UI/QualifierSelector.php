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

namespace WPObjects\View\UI;

class QualifierSelector extends \WPObjects\View\UI\Selector implements
    \WPObjects\Model\ModelTypeFactoryInterface
{
    protected $model_type_id = null;
    protected $qualifier = null;
    
    protected $ModelTypeFactory = null;
    
    protected $Model = null;
    
    public function setModelTypeId($string)
    {
        $this->model_type_id = $string;
        
        return $this;
    }
    
    public function render()
    {
        $ModelType = $this->getModelTypeFactory()->get($this->model_type_id);
        $Models = $ModelType->getFactory()->query()->getResult();
        
        $options = array();
        foreach ($Models as $Model) {
            $options[] = array(
                'id' => $Model->getId(),
                'name' => $Model->getName(),
                'img' => method_exists($Model, 'getImgForSelect') ? $Model->getImgForSelect() : null
            );
        }
        
        if (!$this->lable) {
            $this->setLable($ModelType->getName());
        }
        
        $name = !$this->qualifier ? $this->getModel()->getModelType()->getQualifierAttrName($this->model_type_id) : $this->qualifier;
        $this->setName($name);
        $this->setSelected($this->getModel()->getMeta($this->name));
        $this->setOptions($options);
        
        $this->add_new_link = $ModelType->getAddNewLink();
        if ($ModelType instanceof \WPObjects\PostType\PostType) {
            $this->add_new_text = $ModelType->getLabels('add_new_item');                     
        } else {
            $this->add_new_text = __('Add new entry to') . ' ' . $ModelType->getName();
        }
        
        parent::render();
    }
    
    public function setQualifier($string)
    {
        $this->qualifier = $string;
        
        return $this;
    }
    
    public function setModel($Model)
    {
        $this->Model = $Model;
        
        return $this;
    }
    
    public function getModel()
    {
        return $this->Model;
    }

    public function getModelTypeFactory()
    {
        return $this->ModelTypeFactory;
    }
    
    public function setModelTypeFactory(\WPObjects\Model\ModelTypeFactory $ModelTypeFactory)
    {
        $this->ModelTypeFactory = $ModelTypeFactory;
    }
}