<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    '\WPObjects\Data\DataTypeFactory' => array(
        'DataTypeStorage' => 'setStorage'
    ),
    '\WPObjects\Factory\AbstractData' => array(
        'DataAccess' => 'setData'
    ),
    '\WPObjects\Model\AbstractModelType' => array(
        'ModelTypeFactory' => 'setModelTypeFactory',
        'TypicalModelRestController' => 'setController'
    ),
    '\WPObjects\Model\ModelTypeFactory' => array(
        'PostTypeFactory' => 'addFactory',
        'DataTypeFactory' => 'addFactory',
    ),
    '\WPObjects\PostType\PostTypeFactory' => array(
        'PostTypeStorage' => 'setStorage'
    ),
    '\WPObjects\LessCompiler\Processing' => array(
        'LessCompileParamsFactory' => 'setParamsFactory'
    ),
    '\WPObjects\LessCompiler\ParamsFactory' => array(
        'LessParamsStorage' => 'setStorage'
    ),
    '\WPObjects\Settings\Factory' => array(
        'SettingsStorage' => 'setStorage'
    ),
    
    /**
     * Factories Typical Models
     */
    '\WPObjects\WPFactory\Post' => array(
        'ModelTypePost' => 'setModelType'
    ),
    '\WPObjects\WPFactory\Page' => array(
        'ModelTypePage' => 'setModelType'
    ),
    '\WPObjects\WPFactory\Attachment' => array(
        'ModelTypeAttachment' => 'setModelType'
    ),
    '\WPObjects\VC\AddonFactory' => array(
        'ModelTypeAddon' => 'setModelType'
    ),
    '\WPObjects\GoogleFonts\FontsFactory' => array(
        'ModelTypeGoogleFont' => 'setModelType'
    ),
    '\WPObjects\VC\Template\Factory' => array(
        'ModelTypeVCTemplate' => 'setModelType'
    ),
);