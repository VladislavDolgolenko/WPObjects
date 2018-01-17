<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\WPModel;

class Attachment extends \WPObjects\Model\AbstractPostModel
{
    const THUMBNAIL = 'thumbnail';
    const MEDIUM = 'medium';
    const MEDIUM_LARGE = 'medium_large';
    const LARGE = 'large';
    const FULL = 'full';
    
    protected $default_image_size = self::THUMBNAIL;
    
    public function getImageUrl($size_name = self::THUMBNAIL)
    {
        $size = $this->getImageSize($size_name);
        $file_name = isset($size['file']) ? $size['file'] : null;
        if (!$file_name) {
            return '';
        }
        
        return $this->getFilesDirUrl() . '/' . $file_name;
    }
    
    public function getFilesDirUrl()
    {
        $file_name = $this->getMetaData('file');
        if (!$file_name) {
            return '';
        }
        
        $file_name_url = str_replace('\\', '/', $file_name);
        $dir_name = dirname($file_name_url);
        
        $uploads_dir_data = \wp_upload_dir();
        $uploads_url = isset($uploads_dir_data['baseurl']) ? $uploads_dir_data['baseurl'] : null;
        if (!$uploads_url) {
            return '';
        }
        
        return $uploads_url . DIRECTORY_SEPARATOR . $dir_name;
    }
    
    /**
     * Return image size data by type
     * 
     * @param string $size
     * @return array
     */
    public function getImageSize($size)
    {
        $sizes = $this->getSizes();
        
        if (isset($sizes[$size])) {
            $size = $sizes[$size];
        } else {
            $size = $sizes[$this->default_image_size];
        }
        
        return $size;
    }
    
    public function getSizes()
    {
        $result = array();
        $sizes = $this->getMetaData('sizes');
        if (!is_array($sizes) || !isset($sizes[$this->default_image_size])) {
            $result = array();
        } else {
            $result = $sizes;
        }
        
        // Add full size
        if ($this->getMetaData('file')) {
            $result[self::FULL] = array(
                'width' => $this->getMetaData('width'),
                'height' => $this->getMetaData('height'),
                'file' => basename($this->getMetaData('file')),
            );
        }
        
        return $result;
    }

    public function getMetaData($key = null)
    {
        $metadata = $this->getMeta('_wp_attachment_metadata');
        if ($key) {
            return isset($metadata[$key]) ? $metadata[$key] : null;
        }
        
        return $metadata;
    }
}
