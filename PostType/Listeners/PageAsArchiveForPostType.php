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

namespace WPObjects\PostType\Listeners;

class PageAsArchiveForPostType implements
    \WPObjects\EventManager\ListenerInterface
{
    public function attach()
    {
        \add_filter('post_type_archive_link', array($this, 'process'), 20, 2 );
    }
    
    public function detach()
    {
        \remove_action('post_type_archive_link', array($this, 'process'), 20, 2 );
    }
    
    public function process($link, $post_type)
    {
        $Pages = get_posts(array(
            'post_type' => 'page',
            'meta_query' => array(
                array(
                    'key' => '_page_as_archive',
                    'value' => $post_type
                ),
            ),
        ));
        
        $Page = current($Pages);
        if ($Page) {
            return \get_the_permalink($Page->ID);
        }
        
        return $link;
    }
}