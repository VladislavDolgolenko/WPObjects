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

namespace WPObjects\VC\Template;

class Storage extends \WPObjects\Data\AbstractStorage implements
    \WPObjects\AssetsManager\AssetsManagerInterface
{
    protected $base_folder_path = null;
    protected $config_file_name = 'config.php';
    protected $content_file_name = 'content';
    
    /**
     * @var \WPObjects\AssetsManager\AssetsManager
     */
    protected $AssetsManager = null;
    
    /**
     * Register styles and scripts
     * 
     * @param type $addons_folder_path
     * @return type
     */
    public function readStorage()
    {
        $list = $this->getList();
        
        $result = array();
        foreach ($list as $name) {
            $template = $this->readAddonDir($name);
            if (is_array($template) && isset($template['name'])) {
                $result[] = $template;
            }
        }
        
        return $result;
    }
    
    protected function readAddonDir($path_name)
    {
        $shortcode_dir = $this->getBaseFolderPath() . DIRECTORY_SEPARATOR . $path_name;
        $config_file_path = $this->getBaseFolderPath() . DIRECTORY_SEPARATOR . $path_name . DIRECTORY_SEPARATOR . $this->config_file_name;
        if (!file_exists($config_file_path)) {
            return array();
        }
        
        $template = include $config_file_path;
        if (!isset($template['name'])) {
            return array();
        }
        
        if (!isset($template['id'])) {
            $template['id'] = strtolower(str_replace(array(' ', '/', '\\', '’'), '_', $template['name']));
        }
        
        $id = $template['id'];
        $template['styles'] = array();
        $template['scripts'] = array();
        $scripts_deps = isset($template['scripts_deps']) ? $template['scripts_deps'] : array();
        $styles_deps = isset($template['styles_deps']) ? $template['styles_deps'] : array();
        
        $files = scandir( $shortcode_dir );
        foreach ($files as $file) {
            
            if (preg_match('/.css|.less/', $file) && $this->getAssetsManager()) {
                $asset_name = $id . '-' . current(explode('.', $file));
                $dir_url = \plugin_dir_url( $shortcode_dir . DIRECTORY_SEPARATOR . $file ) ;
                $this->getAssetsManager()->registerStyle($asset_name, $dir_url . $file, $styles_deps);
                $template['styles'][] = $asset_name;
                continue;
            } 
            
            if (preg_match('/.js/', $file) && $this->getAssetsManager()) {
                $asset_name = $id . current(explode('.', $file));
                $dir_url = \plugin_dir_url( $shortcode_dir . DIRECTORY_SEPARATOR . $file ) ;
                $this->getAssetsManager()->registerScript($asset_name, $dir_url . $file, $scripts_deps);
                $template['scripts'][] = $asset_name;
                continue;
            } 
            
            if ($file === $this->content_file_name) {
                $template['content'] = file_get_contents( $shortcode_dir . DIRECTORY_SEPARATOR . $file );
                continue;
            }
            
        }
        
        return $template;
    }
    
    protected function getList()
    {
        $shortcodes_dir = $this->getBaseFolderPath();
        $files = scandir( $shortcodes_dir );
        
        $list = array();
        foreach ($files as $file) {
            if (!is_dir($shortcodes_dir . '/' . $file) || $file == "." || $file == "..") {
                continue;
            }
            
            $list[] = $file;
        }
        
        return $list;
    }
    
    public function setBaseFolderPath($path)
    {
        $this->base_folder_path = $path;
        
        return $this;
    }
    
    public function getBaseFolderPath()
    {
        return $this->base_folder_path;
    }
    
    public function setAssetsManager(\WPObjects\AssetsManager\AssetsManager $AM)
    {
        $this->AssetsManager = $AM;
        
        return $this;
    }
    
    /**
     * @return \WPObjects\AssetsManager\AssetsManager 
     */
    public function getAssetsManager()
    {
        return $this->AssetsManager;
    }
}
