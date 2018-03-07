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