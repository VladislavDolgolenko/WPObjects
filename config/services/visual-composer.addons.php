<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    'ModelTypeAddon' => function ($sm) {
        $Factory = $sm->get('ModelTypeFactory');
        return $Factory->get('vc_addons');
    },
            
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