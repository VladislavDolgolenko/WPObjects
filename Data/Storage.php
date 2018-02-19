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
    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }
        
        $file_path = $this->getFilePath();
        if ($file_path && file_exists($file_path) ) {
            $this->data = (include $file_path);
            //\WPObjects\Log\Loger::getInstance()->write("Storage: " . $this->getFilePath() );
        } else {
            //\WPObjects\Log\Loger::getInstance()->write("ERROR Storage file not exists: " . $Storage->getFilePath() );
        }
        
        return $this->data;
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