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

namespace WPObjects\PostType;

use WPObjects\Factory\AbstractData;
use WPObjects\PostType\PostType as PostTypeModel;

class PostTypeFactory extends AbstractData
{
    protected $initialized = array();
    
    public function initModel($data)
    {
        $id = $data['id'];
        
        if (isset($this->initialized[$id]) && $this->initialized[$id]) {
            return $this->initialized[$id];
        }
        
        $this->initialized[$id] = $this->createModel($data);
        return $this->initialized[$id];
    }
    
    public function createModel($data)
    {
        $Model = new PostTypeModel($data);
        return $this->getServiceManager()->inject($Model);
    }
}