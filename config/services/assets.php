<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    /**
     * Assets Manager
     */
    'AssetsManager' => function ($sm) {
        $AM = new \WPObjects\AssetsManager\AssetsManager();
        
        $AM->setNamespace($sm->get('namespace'))
           ->registerStyles( include $sm->get('wpobjects_dir_path') . '/config/register.styles.php')
           ->addJSTemplates( include $sm->get('wpobjects_dir_path') . '/config/register.templates.php')
           ->registerScripts( include $sm->get('wpobjects_dir_path') . '/config/register.scripts.php');
        
        return $AM;
    },
            
    'LessCompiler' => '\WPObjects\LessCompiler\Processing',
            
    'WPLess' => function($sm){
        return new \WPObjects\LessCompiler\WPless($sm->get('namespace'));
    },
            
    'LessCompileParamsFactory' => '\WPObjects\LessCompiler\ParamsFactory',
            
    'LessParamsStorage' => function ($sm) {
        return new \WPObjects\Data\Storage(array(
            'id' => 'less-params',
            'include' => $sm->get('wpobjects_dir_path') . '/storage/less-params.php',
        ));
    },
    
);