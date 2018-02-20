<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\VC\AddonPreset;

class Model extends \WPObjects\Model\AbstractModel
{
    protected $id = null;
    protected $name = null;
    protected $params = array();
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getParams()
    {
        return $this->params;
    }
    
    public function toJSON()
    {
        $data = $this->toJSON();
        $data['id'] = $this->getId();
        $data['name'] = $this->getName();
        $data['params'] = $this->getParams();
    }
}