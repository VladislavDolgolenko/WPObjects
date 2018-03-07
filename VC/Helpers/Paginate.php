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

namespace WPObjects\VC\Helpers;

class Paginate
{
    static public function quary()
    {
        return array(
            
            array(
                'type' => 'checkbox',
                'heading' => __( 'Hide pagination', 'wpobjects' ),
                'description' => __('Checked this for hide pagination buttons', 'wpobjects'),
                'param_name' => 'hide_pagination',
                'group' => __( 'Pagination', 'wpobjects' )
            ),
            
            array(
                'type' => 'textfield',
                'holder' => 'div',
                'group' => __( 'Pagination', 'wpobjects' ),
                'heading' => __('Item coutn per page', 'wpobjects'),
                'param_name' => 'posts_per_page',
                'description' => __('Use this option only is yout build archive static page', 'wpobjects'),
                'value' => 5,
            ),
            
        );
    }
}