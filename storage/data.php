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
            'category' => esc_html__('Category', 'wpobjects'),
            'query_model_type_name' => esc_html__('Data type', 'wpobjects'),
        ),
    ),
    
    array(
        'id' => 'vc_templates',
        'id_attr_name' => 'id',
        'name' => esc_html__('VC Templates', 'wpobjects'),
        'model_class_name' => '\WPObjects\VC\Template\Model',
        'factory_service_name' => 'VCTemplateFactory',
        'Storage' => $sm->get('VCTemplateStorage'),
        'form_fields' => array(
            
        ),
        'attrs' => array(
            'id' => esc_html__('System id', 'wpobjects'),
            'name' => esc_html__('Name', 'wpobjects')
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