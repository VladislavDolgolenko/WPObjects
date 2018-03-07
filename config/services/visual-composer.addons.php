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

return array(
    
    'ModelTypeAddon' => function ($sm) {
        $Factory = $sm->get('ModelTypeFactory');
        return $Factory->get('vc_addons');
    },
    'ShorcodeParams' => '\WPObjects\VC\ShorcodeParams',
            
    'AddonFactory' => '\WPObjects\VC\AddonFactory',
            
    'AddonsStorage' => function($sm) {
        $Storage = new \WPObjects\VC\Storage(array(
            'id' => 'vc_addons'
        ));
        $Storage->setBaseFolderPath( $sm->get('vc_addons_dir_path') );
        $Storage->set('less_params_file_name', 'colors.php');
        
        return $Storage;
    },
            
    /**
     * Templates
     */
    'ModelTypeVCTemplate' => function ($sm) {
        $Factory = $sm->get('ModelTypeFactory');
        return $Factory->get('vc_templates');
    },
    'VCTemplateFactory' => '\WPObjects\VC\Template\Factory',
    'VCTemplateStorage' => function($sm) {
        $Storage = new \WPObjects\VC\Template\Storage(array(
            'id' => 'vc_templates'
        ));
        $Storage->setBaseFolderPath( $sm->get('vc_templates_dir_path') );
        
        return $Storage;
    },
            
    /**
     * Customization and settings
     */
    'AddonsCustomizer' => function ($sm) {
        $Customizer = new \WPObjects\VC\AddonsWPCustomizer();
        $Customizer->setAddonsFactory($sm->get('AddonFactory'));
        
        return $Customizer;
    },
    'ModelTypeGoogleFont' => function ($sm) {
        $Factory = $sm->get('ModelTypeFactory');
        return $Factory->get('google_font');
    },
    'FontsFactory' => '\WPObjects\GoogleFonts\FontsFactory',
    'GoogleFontsStorage' => function(){
        return new \WPObjects\GoogleFonts\Storage(array(
            'id' => 'google_fonts'
        ));
    },
    
);