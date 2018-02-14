<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

$sm = \WPObjects\Service\Manager::getInstance();

return array(
    
    array(
        'id' => 'vc_addons',
        'id_attr_name' => 'base',
        'name' => esc_html__('VC Addons', 'wpobjects'),
        'model_class_name' => '\WPObjects\VC\CustomAddonModel',
        'factory_service_name' => 'AddonFactory',
        'Storage' => $sm->get('AddonsStorage'),
        'form_fields' => array(
            
        ),
        'attrs' => array(
            'base' => esc_html__('System id', 'wpobjects'),
            'name' => esc_html__('Name', 'wpobjects'),
        ),
    ),
    
    array(
        'id' => 'google_font',
        'id_attr_name' => 'family',
        'name' => esc_html__('Google fonts', 'wpobjects'),
        'model_class_name' => '\WPObjects\GoogleFonts\Model',
        'factory_service_name' => 'FontsFactory',
        'Storage' => $sm->get('GoogleFontsStorage'),
        'form_fields' => array(
            
        ),
        'attrs' => array(
            'family' => esc_html__('System id', 'wpobjects'),
            'category' => esc_html__('Category', 'area'),
        ),
    ),
    
);