<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace MSP\MetaBox;

class CustomAttributes extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('custom-attributes');
        $this->setTitle('Custom attributes');
        $this->setPosition('normal');
        $this->setPriority('default');
    }
    
    public function processing(\MSP\WPObjects\Model\AbstractPostModel $Post, $data)
    {
        if (!isset($data['attrs_counter']) || !is_array($data['attrs_counter'])) {
            return array();
        }
        
        $counter = $data['attrs_counter'];
        $atts = array();
        foreach ($counter as $key => $count) {
            $atts[$key] = array( 
                'name' => \sanitize_text_field($data['attr_name'][$key]), 
                'text' => \sanitize_text_field($data['attr_text'][$key]), 
            );
        }
        
        return array(
            '_attrs' => $atts
        );
    }
    
    public function enqueues()
    {
        parent::enqueues();
        
        wp_enqueue_script('msp_metabox_attributes', MSP_PATH_URL . 'js/meta-boxes/attributes.js', array('backbone'), null, true);
    }
    
    public function getElements()
    {
        $elements = $this->getPostModel()->getMeta('_attrs');
        
        if (!is_array($elements) || count($elements) === 0) {
            $elements = array(
                array(
                    'name' => null,
                    'text' => null
                )
            );
        }
        
        if (!is_array(current($elements))) {
            $elements = array($elements);
        }
        
        return $elements;
    }
}