<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

use WPObjects\Model\AbstractModel;

class Storage extends AbstractModel
{
    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->id;
    }
    
    public function getFilePath()
    {
        return $this->include;
    }
}