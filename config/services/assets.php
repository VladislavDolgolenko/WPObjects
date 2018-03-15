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
            
    'GoogleFontsEnqueueUrl' => function ($sm) {
        $Factory = $sm->get('LessCompileParamsFactory');
        return $Factory->getUrlForEnqueueGoogleFontsParams();
    },
    
);