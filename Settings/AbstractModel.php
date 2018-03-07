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

namespace WPObjects\Settings;

abstract class AbstractModel extends \WPObjects\Model\AbstractModel
{
    const TYPE_TEXT = 'text';
    const TYPE_NUMBER = 'number';
    const TYPE_DATE = 'date';
    const TYPE_URL = 'url';
    const TYPE_SELECT = 'select';
    const TYPE_MULTIPLE = 'multiple';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_IMAGE = 'image';
    
    protected $id = '';
    protected $name = '';
    protected $group = 'Other';
    protected $default = '';
    protected $description = '';
    protected $type = self::TYPE_TEXT;

    abstract public function getCurrentValue();
    
    abstract public function setCurrentValue($value);

    public function getName()
    {
        return $this->get('name');
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getDefault()
    {
        return $this->default;
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getGroup()
    {
        return $this->group;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function getViewUI()
    {
        if ($this->getType() === self::TYPE_TEXT) {
            
        }
    }
}