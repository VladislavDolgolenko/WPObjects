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

namespace WPObjects\VC\Shortcode;

class PostsShortcode extends DefaultShortcode
{
    public static $excluded_ids = array();
    protected $filter_terms;
    public $items = array();
    public $post_id = false;
    public $attributes_defaults = array(
        'items_per_page' => '5',
        'show_filter' => '',
        'exclude_filter' => '',
        'filter_style' => '',
        'filter_size' => 'md',
        'filter_align' => '',
        'filter_color' => '',
        'arrows_design' => '',
        'arrows_position' => '',
        'arrows_color' => '',
        'paging_design' => '',
        'disable_arrows' => 'yes',
        'paging_color' => '',
        'paging_animation_in' => '',
        'paging_animation_out' => '',
        'loop' => '',
        'autoplay' => '',
        'post_type' => 'post',
        'filter_source' => 'category',
        'orderby' => '',
        'order' => 'DESC',
        'meta_key' => '',
        'meta_compare' => '',
        'max_items' => '10',
        'offset' => '0',
        'taxonomies' => '',
        'custom_query' => '',
        'data_type' => 'query',
        'include' => '',
        'exclude' => '',
        'item' => 'none',
        'grid_id' => '',
        // disabled, needed for-BC:
        'button_style' => '',
        'button_color' => '',
        'button_size' => '',
        // New button3:
        'btn_title' => '',
        'btn_style' => 'modern',
        'btn_el_id' => '',
        'btn_custom_background' => '#ededed',
        'btn_custom_text' => '#666',
        'btn_outline_custom_color' => '#666',
        'btn_outline_custom_hover_background' => '#666',
        'btn_outline_custom_hover_text' => '#fff',
        'btn_shape' => 'rounded',
        'btn_color' => 'blue',
        'btn_size' => 'md',
        'btn_align' => 'inline',
        'btn_button_block' => '',
        'btn_add_icon' => '',
        'btn_i_align' => 'left',
        'btn_i_type' => 'fontawesome',
        'btn_i_icon_fontawesome' => 'fa fa-adjust',
        'btn_i_icon_openiconic' => 'vc-oi vc-oi-dial',
        'btn_i_icon_typicons' => 'typcn typcn-adjust-brightness',
        'btn_i_icon_entypo' => 'entypo-icon entypo-icon-note',
        'btn_i_icon_linecons' => 'vc_li vc_li-heart',
        'btn_i_icon_pixelicons' => 'vc_pixel_icon vc_pixel_icon-alert',
        'btn_custom_onclick' => '',
        'btn_custom_onclick_code' => '',
        // fix template
        'page_id' => '',
        'animation_in' => '',
        'title' => '',
    );
    
    public static function addExcludedId( $id )
    {
        self::$excluded_ids[] = $id;
    }

    public static function excludedIds()
    {
        return self::$excluded_ids;
    }
    
    public function buildAtts($atts)
    {
        $arr_keys = array_keys( $atts );
        for ( $i = 0; $i < count( $atts ); $i ++ ) {
            $atts[ $arr_keys[ $i ] ] = html_entity_decode( $atts[ $arr_keys[ $i ] ], ENT_QUOTES, 'utf-8' );
        }

        $atts = shortcode_atts( array_merge(vc_map_get_defaults($this->getShortcode()), $this->attributes_defaults), vc_map_get_attributes( $this->getShortcode(), $atts ) );
        $this->atts = $atts;
        $this->atts['page_id'] = $this->postID();
        return $atts;
    }
    
    public function buildQuery($atts)
    {
        // Set include & exclude
        if ('ids' !== $atts['post_type'] && !empty($atts['exclude'])) {
            $atts['exclude'] .= ',' . implode(',', $this->excludedIds());
        } else {
            $atts['exclude'] = implode(',', $this->excludedIds());
        }
        if ('ids' !== $atts['post_type']) {
            $settings = array(
                'posts_per_page' => $atts['query_items_per_page'],
                'offset' => $atts['query_offset'],
                'orderby' => $atts['orderby'],
                'order' => $atts['order'],
                'meta_key' => in_array($atts['orderby'], array(
                    'meta_value',
                    'meta_value_num',
                )) || isset($atts['meta_key']) ? $atts['meta_key'] : '',
                'post_type' => $atts['post_type'],
                'exclude' => $atts['exclude'],
                'meta_compare' => isset($atts['meta_compare']) ? $atts['meta_compare'] : '',
            );
            if (!empty($atts['taxonomies'])) {
                $vc_taxonomies_types = get_taxonomies(array('public' => true));
                $terms = get_terms(array_keys($vc_taxonomies_types), array(
                    'hide_empty' => false,
                    'include' => $atts['taxonomies'],
                        ));
                $settings['tax_query'] = array();
                $tax_queries = array(); // List of taxnonimes
                foreach ($terms as $t) {
                    if (!isset($tax_queries[$t->taxonomy])) {
                        $tax_queries[$t->taxonomy] = array(
                            'taxonomy' => $t->taxonomy,
                            'field' => 'id',
                            'terms' => array($t->term_id),
                            'relation' => 'IN',
                        );
                    } else {
                        $tax_queries[$t->taxonomy]['terms'][] = $t->term_id;
                    }
                }
                $settings['tax_query'] = array_values($tax_queries);
                $settings['tax_query']['relation'] = 'OR';
            }
        } else {
            if (empty($atts['include'])) {
                $atts['include'] = - 1;
            } elseif (!empty($atts['exclude'])) {
                $include = array_map('trim', explode(',', $atts['include']));
                $exclude = array_map('trim', explode(',', $atts['exclude']));
                $diff = array_diff($include, $exclude);
                $atts['include'] = implode(', ', $diff);
            }
            $settings = array(
                'include' => $atts['include'],
                'posts_per_page' => $atts['query_items_per_page'],
                'offset' => $atts['query_offset'],
                'post_type' => 'any',
                'orderby' => 'post__in',
            );
            $this->atts['items_per_page'] = - 1;
        }

        return $settings;
    }
    
    public function buildItems()
    {
        $this->filter_terms = $this->items = array();

        $this->setContentLimits();

        $this->addExcludedId($this->postID());
        if ('custom' === $this->atts['post_type'] && !empty($this->atts['custom_query'])) {
            $query = html_entity_decode(vc_value_from_safe($this->atts['custom_query']), ENT_QUOTES, 'utf-8');
            $post_data = get_posts($query);
            $this->atts['items_per_page'] = - 1;
        } elseif (false !== $this->atts['query_items_per_page']) {
            $settings = $this->filterQuerySettings($this->buildQuery($this->atts));
            //var_dump($settings);
            $post_data = get_posts($settings);
        } else {
            return;
        }
        
        if ($this->atts['items_per_page'] > 0 && count($post_data) > $this->atts['items_per_page']) {
            $post_data = array_slice($post_data, 0, $this->atts['items_per_page']);
        }
        
        foreach ($post_data as $post) {
            //$post->filter_terms = wp_get_object_terms($post->ID, $this->atts['filter_source'], array('fields' => 'ids'));
            //$this->filter_terms = wp_parse_args($this->filter_terms, $post->filter_terms);
            $this->items[] = $post;
        }
        
        return $this->items;
    }
    
    public function postID()
    {
        if (false == $this->post_id) {
            $this->post_id = get_the_ID();
        }

        return $this->post_id;
    }

    public function setContentLimits()
    {
        $atts = $this->atts;
        if ( 'ids' === $this->atts['post_type'] ) {
                $this->atts['max_items'] = 0;
                $this->atts['offset'] = 0;
                $this->atts['items_per_page'] = apply_filters( 'vc_basic_grid_max_items', self::$default_max_items );
        } else {
                $this->atts['offset'] = $offset = isset( $atts['offset'] ) ? (int) $atts['offset'] : $this->attributes_defaults['offset'];
                $this->atts['max_items'] = isset( $atts['max_items'] ) ? (int) $atts['max_items'] : (int) $this->attributes_defaults['max_items'];
                $this->atts['items_per_page'] = ! isset( $atts['items_per_page'] ) ? (int) $this->attributes_defaults['items_per_page'] : (int) $atts['items_per_page'];
                if ( $this->atts['max_items'] < 1 ) {
                        $this->atts['max_items'] = apply_filters( 'vc_basic_grid_max_items', self::$default_max_items );
                }
        }
        $this->setPagingAll( $this->atts['max_items'] );
    }
    
    protected function setPagingAll( $max_items )
    {
        $atts = $this->atts;
        $this->atts['items_per_page'] = $this->atts['query_items_per_page'] = $max_items > 0 ? $max_items : apply_filters('vc_basic_grid_items_per_page_all_max_items', self::$default_max_items);
        $this->atts['query_offset'] = isset($atts['offset']) ? (int) $atts['offset'] : $this->attributes_defaults['offset'];
    }

    public function filterQuerySettings($args)
    {
        $defaults = array(
            'numberposts' => 5,
            'offset' => 0,
            'category' => 0,
            'orderby' => 'date',
            'order' => 'DESC',
            'include' => array(),
            'exclude' => array(),
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => 'post',
            'suppress_filters' => apply_filters('vc_basic_grid_filter_query_suppress_filters', true),
            'public' => true,
        );

        $r = wp_parse_args($args, $defaults);
        if (empty($r['post_status'])) {
            $r['post_status'] = ( 'attachment' === $r['post_type'] ) ? 'inherit' : 'publish';
        }
        if (!empty($r['numberposts']) && empty($r['posts_per_page'])) {
            $r['posts_per_page'] = $r['numberposts'];
        }
        if (!empty($r['category'])) {
            $r['cat'] = $r['category'];
        }
        if (!empty($r['include'])) {
            $incposts = wp_parse_id_list($r['include']);
            $r['posts_per_page'] = count($incposts);  // only the number of posts included
            $r['post__in'] = $incposts;
        } elseif (!empty($r['exclude'])) {
            $r['post__not_in'] = wp_parse_id_list($r['exclude']);
        }

        $r['ignore_sticky_posts'] = true;
        $r['no_found_rows'] = true;

        return $r;
    }

}