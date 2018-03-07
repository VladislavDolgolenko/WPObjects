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