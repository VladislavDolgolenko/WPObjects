<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

return array(
    
    '\WPObjects\Model\AbstractModelType' => array(
        'ModelTypeFactory' => 'setModelTypeFactory',
        'TypicalModelRestController' => 'setController'
    ),
    '\WPObjects\Factory\AbstractData' => array(
        'DataAccess' => 'setData'
    ),
    '\WPObjects\Model\ModelTypeFactory' => array(
        'PostTypeFactory' => 'addFactory',
        'DataTypeFactory' => 'addFactory',
    ),
    
    '\WPObjects\PostType\PostTypeFactory' => array(
        'PostTypeStorage' => 'setStorage'
    ),
    '\WPObjects\Data\DataTypeFactory' => array(
        'DataTypeStorage' => 'setStorage'
    ),
    '\WPObjects\LessCompiler\Processing' => array(
        'LessCompileParamsFactory' => 'setParamsFactory'
    ),
    '\WPObjects\LessCompiler\ParamsFactory' => array(
        'LessParamsStorage' => 'setStorage'
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
    '\AREA\Factory\Addon' => array(
        'ModelTypeAddon' => 'setModelType'
    ),
    '\WPObjects\GoogleFonts\FontsFactory' => array(
        'ModelTypeGoogleFont' => 'setModelType'
    ),
);