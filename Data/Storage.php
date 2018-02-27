<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Data;

class Storage extends AbstractStorage
{
    protected $include = null;
    
    /**
     * Return storage data
     * 
     * @return array
     */
    public function readStorage()
    {
        $data = array();
        $file_path = $this->getFilePath();
        if ($file_path && file_exists($file_path) ) {
            $data = (include $file_path);
        } 
        
        return $data;
    }
    
    public function getFilePath()
    {
        return $this->include;
    }
    
    public function setFilePath($string)
    {
        $this->include = $string;
        
        return $this;
    }
}