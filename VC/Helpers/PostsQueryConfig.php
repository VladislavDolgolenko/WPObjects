<?php

namespace WPObjects\VC\Helpers;

class PostsQueryConfig
{
    static public function allMenuPages()
    {
        return array(
            array(
                "type" => "autocomplete",
                "heading" => __( "Select pages for showing in navigation", "msp" ),
                "param_name" => "_page_id",
                'settings' => array(
                    'multiple' => true,
                    'unique_values' => true,
                    'sortable' => true,
                    'groups' => true,
                    'auto_focus' => true,
                    "values" => self::getAllPostsForAutocomplete(),
                ),
            ),
        );
    }
    
    static public function postsSelector()
    {
        return array(
            array(
                "type" => "autocomplete",
                "heading" => __( "Select posts for showing in slider", "msp" ),
                "param_name" => "_page_id",
                'settings' => array(
                    'multiple' => true,
                    'unique_values' => true,
                    'sortable' => true,
                    'groups' => true,
                    'auto_focus' => true,
                    "values" => self::getAllPostsForAutocomplete(),
                ),
            ),
        );
    }
    
    static public function getAllPostsForAutocomplete()
    {
        $posts = get_posts(array('numberposts' => -1, 'post_type' => 'any'));
        
        $autocomplete_posts = array();
        foreach ($posts as $post) {
            $autocomplete_posts[] = array(
                'label' => (string)get_the_title($post),
                'value' => (int)$post->ID,
                'group' => (string)$post->post_type
            );
        }
        
        return $autocomplete_posts;
    }
    
    static public function quary() 
    {
        $postTypes = get_post_types(array());
        $postTypesList = array();
        $excludedPostTypes = array(
            'revision',
            'nav_menu_item',
            'vc_grid_item',
        );
        if (is_array($postTypes) && !empty($postTypes)) {
            foreach ($postTypes as $postType) {
                if (!in_array($postType, $excludedPostTypes)) {
                    $label = ucfirst($postType);
                    $postTypesList[] = array(
                        $postType,
                        $label,
                    );
                }
            }
        }
        $postTypesList[] = array(
            'custom',
            __('Custom query', 'js_composer'),
        );
        $postTypesList[] = array(
            'ids',
            __('List of IDs', 'js_composer'),
        );

        return array(
            array(
                'type' => 'dropdown',
                'heading' => __('Data source', 'js_composer'),
                'param_name' => 'post_type',
                'value' => $postTypesList,
                'save_always' => true,
                'description' => __('Select content type for your grid.', 'js_composer'),
                'group' => __('Posts', 'js_composer'),
                'admin_label' => true,
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Max posts displayed", 'msp'),
                "param_name" => "numberposts",
                'group' => __('Posts', 'js_composer'),
                "value" => 5,
            ),
            array(
                'type' => 'autocomplete',
                'heading' => __('Narrow data source', 'js_composer'),
                'group' => __('Posts', 'js_composer'),
                'param_name' => 'taxonomies',
                'settings' => array(
                    'multiple' => true,
                    'min_length' => 1,
                    'groups' => true,
                    // In UI show results grouped by groups, default false
                    'unique_values' => true,
                    // In UI show results except selected. NB! You should manually check values in backend, default false
                    'display_inline' => true,
                    // In UI show results inline view, default false (each value in own line)
                    'delay' => 500,
                    // delay for search. default 500
                    'auto_focus' => true,
                // auto focus input, default true
                ),
                'param_holder_class' => 'vc_not-for-custom',
                'description' => __('Enter categories, tags or custom taxonomies.', 'js_composer'),
                'dependency' => array(
                    'element' => 'post_type',
                    'value_not_equal_to' => array(
                        'ids',
                        'custom',
                    ),
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Order by', 'js_composer'),
                'group' => __('Sort', 'js_composer'),
                'param_name' => 'orderby',
                'value' => array(
                    __('Date', 'js_composer') => 'date',
                    __('Order by post ID', 'js_composer') => 'ID',
                    __('Author', 'js_composer') => 'author',
                    __('Title', 'js_composer') => 'title',
                    __('Last modified date', 'js_composer') => 'modified',
                    __('Post/page parent ID', 'js_composer') => 'parent',
                    __('Number of comments', 'js_composer') => 'comment_count',
                    __('Menu order/Page Order', 'js_composer') => 'menu_order',
                    __('Meta value', 'js_composer') => 'meta_value',
                    __('Meta value number', 'js_composer') => 'meta_value_num',
                    __('Random order', 'js_composer') => 'rand',
                ),
                'description' => __('Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer'),
                'param_holder_class' => 'vc_grid-data-type-not-ids',
                'dependency' => array(
                    'element' => 'post_type',
                    'value_not_equal_to' => array(
                        'ids',
                        'custom',
                    ),
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Sort order', 'js_composer'),
                'param_name' => 'order',
                'group' => __('Sort', 'js_composer'),
                'value' => array(
                    __('Descending', 'js_composer') => 'DESC',
                    __('Ascending', 'js_composer') => 'ASC',
                ),
                'param_holder_class' => 'vc_grid-data-type-not-ids',
                'description' => __('Select sorting order.', 'js_composer'),
                'dependency' => array(
                    'element' => 'post_type',
                    'value_not_equal_to' => array(
                        'ids',
                        'custom',
                    ),
                ),
            ),
        );
    }
    
    static public function extendQuery()
    {

        $postTypes = get_post_types( array() );
        $postTypesList = array();
        $excludedPostTypes = array(
                'revision',
                'nav_menu_item',
                'vc_grid_item',
        );
        if ( is_array( $postTypes ) && ! empty( $postTypes ) ) {
                foreach ( $postTypes as $postType ) {
                        if ( ! in_array( $postType, $excludedPostTypes ) ) {
                                $label = ucfirst( $postType );
                                $postTypesList[] = array(
                                        $postType,
                                        $label,
                                );
                        }
                }
        }
        $postTypesList[] = array(
                'custom',
                __( 'Custom query', 'js_composer' ),
        );
        $postTypesList[] = array(
                'ids',
                __( 'List of IDs', 'js_composer' ),
        );

        $taxonomiesForFilter = array();

        if ( 'vc_edit_form' === vc_post_param( 'action' ) ) {
                $vcTaxonomiesTypes = vc_taxonomies_types();
                if ( is_array( $vcTaxonomiesTypes ) && ! empty( $vcTaxonomiesTypes ) ) {
                        foreach ( $vcTaxonomiesTypes as $t => $data ) {
                                if ( 'post_format' !== $t && is_object( $data ) ) {
                                        $taxonomiesForFilter[ $data->labels->name . '(' . $t . ')' ] = $t;
                                }
                        }
                }
        }
        
        return array (
        
            array(
                    'type' => 'dropdown',
                    'heading' => __( 'Data source', 'js_composer' ),
                    'param_name' => 'post_type',
                    'value' => $postTypesList,
                    'save_always' => true,
                    'description' => __( 'Select content type for your grid.', 'js_composer' ),
                    'admin_label' => true,
            ),
            array(
                    'type' => 'autocomplete',
                    'heading' => __( 'Include only', 'js_composer' ),
                    'param_name' => 'include',
                    'description' => __( 'Add posts, pages, etc. by title.', 'js_composer' ),
                    'settings' => array(
                            'multiple' => true,
                            'sortable' => true,
                            'groups' => true,
                    ),
                    'dependency' => array(
                            'element' => 'post_type',
                            'value' => array( 'ids' ),
                    ),
            ),
            array(
                    'type' => 'textarea_safe',
                    'heading' => __( 'Custom query', 'js_composer' ),
                    'param_name' => 'custom_query',
                    'description' => __( 'Build custom query according to <a href="http://codex.wordpress.org/Function_Reference/query_posts">WordPress Codex</a>.', 'js_composer' ),
                    'dependency' => array(
                        'element' => 'post_type',
                        'value' => array( 'custom' ),
                    ),
            ),
            array(
                    'type' => 'autocomplete',
                    'heading' => __( 'Narrow data source', 'js_composer' ),
                    'param_name' => 'taxonomies',
                    'settings' => array(
                            'multiple' => true,
                            'min_length' => 1,
                            'groups' => true,
                            // In UI show results grouped by groups, default false
                            'unique_values' => true,
                            // In UI show results except selected. NB! You should manually check values in backend, default false
                            'display_inline' => true,
                            // In UI show results inline view, default false (each value in own line)
                            'delay' => 500,
                            // delay for search. default 500
                            'auto_focus' => true,
                            // auto focus input, default true
                    ),
                    'param_holder_class' => 'vc_not-for-custom',
                    'description' => __( 'Enter categories, tags or custom taxonomies.', 'js_composer' ),
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                    ),
            ),
            array(
                    'type' => 'textfield',
                    'heading' => __( 'Total items', 'js_composer' ),
                    'param_name' => 'max_items',
                    'value' => 10,
                    // default value
                    'param_holder_class' => 'vc_not-for-custom',
                    'description' => __( 'Set max limit for items in grid or enter -1 to display all (limited to 1000).', 'js_composer' ),
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                    ),
            ),
           
            array(
                    'type' => 'textfield',
                    'heading' => __( 'Items per page', 'js_composer' ),
                    'param_name' => 'items_per_page',
                    'description' => __( 'Number of items to show per page.', 'js_composer' ),
                    'value' => '10',
                    'dependency' => array(
                            'element' => 'style',
                            'value' => array(
                                    'lazy',
                                    'load-more',
                                    'pagination',
                            ),
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
            ),
            
            array(
                    'type' => 'dropdown',
                    'heading' => __( 'Order by', 'js_composer' ),
                    'param_name' => 'orderby',
                    'value' => array(
                            __( 'Date', 'js_composer' ) => 'date',
                            __( 'Order by post ID', 'js_composer' ) => 'ID',
                            __( 'Author', 'js_composer' ) => 'author',
                            __( 'Title', 'js_composer' ) => 'title',
                            __( 'Last modified date', 'js_composer' ) => 'modified',
                            __( 'Post/page parent ID', 'js_composer' ) => 'parent',
                            __( 'Number of comments', 'js_composer' ) => 'comment_count',
                            __( 'Menu order/Page Order', 'js_composer' ) => 'menu_order',
                            __( 'Meta value', 'js_composer' ) => 'meta_value',
                            __( 'Meta value number', 'js_composer' ) => 'meta_value_num',
                            __( 'Random order', 'js_composer' ) => 'rand',
                    ),
                    'description' => __( 'Select order type. If "Meta value" or "Meta value Number" is chosen then meta key is required.', 'js_composer' ),
                    'group' => __( 'Data Settings', 'js_composer' ),
                    'param_holder_class' => 'vc_grid-data-type-not-ids',
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                    ),
            ),
            array(
                    'type' => 'dropdown',
                    'heading' => __( 'Sort order', 'js_composer' ),
                    'param_name' => 'order',
                    'group' => __( 'Data Settings', 'js_composer' ),
                    'value' => array(
                            __( 'Descending', 'js_composer' ) => 'DESC',
                            __( 'Ascending', 'js_composer' ) => 'ASC',
                    ),
                    'param_holder_class' => 'vc_grid-data-type-not-ids',
                    'description' => __( 'Select sorting order.', 'js_composer' ),
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                    ),
            ),
            array(
                    'type' => 'textfield',
                    'heading' => __( 'Meta key', 'js_composer' ),
                    'param_name' => 'meta_key',
                    'description' => __( 'Input meta key for grid ordering.', 'js_composer' ),
                    'group' => __( 'Data Settings', 'js_composer' ),
                    'param_holder_class' => 'vc_grid-data-type-not-ids',
                    'dependency' => array(
                            'element' => 'orderby',
                            'value' => array(
                                    'meta_value',
                                    'meta_value_num',
                            ),
                    ),
            ),
            array(
                    'type' => 'textfield',
                    'heading' => __( 'Offset', 'js_composer' ),
                    'param_name' => 'offset',
                    'description' => __( 'Number of grid elements to displace or pass over.', 'js_composer' ),
                    'group' => __( 'Data Settings', 'js_composer' ),
                    'param_holder_class' => 'vc_grid-data-type-not-ids',
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                    ),
            ),
            array(
                    'type' => 'autocomplete',
                    'heading' => __( 'Exclude', 'js_composer' ),
                    'param_name' => 'exclude',
                    'description' => __( 'Exclude posts, pages, etc. by title.', 'js_composer' ),
                    'group' => __( 'Data Settings', 'js_composer' ),
                    'settings' => array(
                            'multiple' => true,
                    ),
                    'param_holder_class' => 'vc_grid-data-type-not-ids',
                    'dependency' => array(
                            'element' => 'post_type',
                            'value_not_equal_to' => array(
                                    'ids',
                                    'custom',
                            ),
                            'callback' => 'vc_grid_exclude_dependency_callback',
                    ),
            ),
            
        );
    }
    
    

}
