<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\FileSystem;

if (!function_exists('\WP_Filesystem')) {
    require_once ABSPATH . '/wp-admin/includes/file.php';
}

if (!class_exists('\WP_Filesystem_Base')) {
    require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
}

class FileSystem
{
    static protected $_instance = null;
    
    /**
     * @global \WP_Filesystem_Base $wp_filesystem
     * @return \WP_Filesystem_Base
     * @throws \Exception
     */
    static public function getInstance()
    {
        if (self::$_instance instanceof \WP_Filesystem_Base) {
            return self::$_instance;
        }
        
        global $wp_filesystem;
        if ($wp_filesystem instanceof \WP_Filesystem_Base) {
            self::$_instance = $wp_filesystem;
        } else if (function_exists('\WP_Filesystem') && \WP_Filesystem() === true && $wp_filesystem instanceof \WP_Filesystem_Base) {
            self::$_instance = $wp_filesystem;
        } else {
            return $wp_filesystem;
            //throw new \Exception('System error: not undefined wordpress filesystem methods');
        }
        
        return self::$_instance;
    }
}