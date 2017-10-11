<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Model;

abstract class AbstractModel extends \ArrayObject implements ModelInterface
{
    public function __construct($data)
    {
        parent::__construct(array(), self::ARRAY_AS_PROPS, "ArrayIterator");
        $this->exchange($data);
    }
    
    public function exchange($data)
    {
        if (is_array($data)) {
            $this->exchangeArray($data);
        } else if (is_object($data)) {
            $this->exchangeObject($data);
        } else {
            throw new \Exception('Undefined model echanged data type, must be array or object.');
        }
    }
    
    protected function exchangeObject($data)
    {
        foreach (\get_object_vars($data) as $key => $value) {
            $this->$key = $value;
        }
    }
    
    public function exchangeArray($data)
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
    
}

