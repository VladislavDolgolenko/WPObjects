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

namespace WPObjects\Data\Dashboard;

class Page extends \WPObjects\Page\AdminPage
{
    protected $assets_dir_url = null;
    protected $assets_dir_path = null;
    
    public function __construct()
    {
        $this->setMenuName(__( 'Database', 'msp' ));
        $this->setTitle(__( 'Database', 'msp' ));
        $this->setPermission('manage_options');
        $this->setId('database');
        $this->setMenuPosition(30);
        
        $assets_dit_path = dirname(__FILE__) . '/assets';
        $this->setAssetsDirPath($assets_dit_path);
        $this->setAssetsDirUrl(plugin_dir_url($assets_dit_path . '/custom'));
        $this->setTemplatePath(dirname(__FILE__) . '/templates/dashboard.php');
    }
    
    public function enqueues()
    {
        $AM = $this->getAssetsManager();
        
        $AM->enqueueScript('page-dashboard')
           ->enqueueStyle('database');
    }
    
    public function getAssetsDirUrl()
    {
        return $this->assets_dir_url;
    }
    
    public function setAssetsDirUrl($string)
    {
        $this->assets_dir_url = $string;
    }
    
    public function getAssetsDirPath()
    {
        return $this->assets_dir_path;
    }
    
    public function setAssetsDirPath($string)
    {
        $this->assets_dir_path = $string;
    }
}