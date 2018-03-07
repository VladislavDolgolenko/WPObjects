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

namespace WPObjects\Log;

class Loger
{
    protected $file_path = null;
    
    protected $active = false;
    
    private static $_instance = null;
    
    /**
     * @return \WPObjects\Log\Loger
     */
    static public function getInstance()
    {
        $class = get_called_class();
        if (is_null(self::$_instance)) {
            self::$_instance = new $class();
        }
        
        return self::$_instance;
    }
    
    public function __construct()
    {
        return;
        $this->file_path = ABSPATH . '/wp-content/log.txt';
        $this->active = true;
        $this->clean();
    }
    
    public function write($line_message)
    {
        return;
        if (!$this->active) {
            return;
        }
        
        $content = file_get_contents($this->file_path);
        
        $line = $line_message . "\n";
        //echo $line;
        
        $content .= $line;
        
        file_put_contents($this->file_path, $content);
    }
    
    protected function clean()
    {
        if (!$this->active) {
            return;
        }
        
        file_put_contents($this->file_path, ' ');
    }
}