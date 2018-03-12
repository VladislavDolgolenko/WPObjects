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

namespace WPObjects\PostType\MetaBox;

class PageAsArchive extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('page_as_archive');
        $this->setTitle('Page as archive');
        $this->setPosition('side');
        $this->setPriority('low');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'page-as-archive.php');
    }
    
    public function getPostTypesForSelect()
    {
        $post_types = \get_post_types(array(
            'public' => true
        ));
        
        $result = array();
        foreach ($post_types as $post_type) {
            $PostType = \get_post_type_object($post_type);
            $result[] = array(
                'id' => $post_type,
                'name' => $PostType->labels->name,
            );
        }
        
        return $result;
    }
}