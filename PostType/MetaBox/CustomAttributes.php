<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\PostType\MetaBox;

class CustomAttributes extends AbstractMetaBox
{
    public function __construct()
    {
        $this->setId('custom-attributes');
        $this->setTitle('Custom attributes');
        $this->setPosition('normal');
        $this->setPriority('default');
        
        $template_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'templates';
        $this->setTemplatePath($template_dir . DIRECTORY_SEPARATOR . 'custom-attributes.php');
    }
    
    public function enqueues()
    {
        parent::enqueues();
        $this->getAssetsManager()->enqueueScript('metabox_attributes');
    }
    
    public function processing(\WPObjects\Model\AbstractPostModel $Post, $data)
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