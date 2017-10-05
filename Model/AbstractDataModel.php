<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractDataModel extends AbstractModel
{
    /**
     * @param array $data
     */
    public function __construct($data)
    {
        parent::__construct($data);
        $this->exchangeArray($data);
    }
    
    public function getMeta($key)
    {
        return $this->$key;
    }
    
    public function setMeta($key, $value)
    {
        return $this->$key = $value;
    }
    
    public function save()
    {
        return;
    }
}
