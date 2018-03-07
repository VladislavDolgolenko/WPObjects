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
     * Namespace injection
     */
    '\WPObjects\Service\NamespaceInterface' => array(
        'namespace' => 'setNamespace'
    ),
    
    /**
     * Version injection
     */
    '\WPObjects\Service\VersionInterface' => array(
        'build' => 'setVersion'
    ),
    
    /**
     * Session
     */
    '\WPObjects\Session\StorageInterface' => array(
        'SessionStorage' => 'setSessionStorage'
    ),
    '\WPObjects\Session\CookiesInterface' => array(
        'Cookies' => 'setCookies'
    ),
    
    /**
     * Assets manager injection
     */
    '\WPObjects\AssetsManager\AssetsManagerInterface' => array(
        'AssetsManager' => 'setAssetsManager'
    ),
    
    /**
     * Inject to all model factories query filters listeners
     */
    '\WPObjects\Factory\TypicalModelFactoryInterface' => array(
        'WordpressContextFilter' => 'attachListenersAggregator',
        'AggregatorFilter' => 'attachListenersAggregator'
    ),
    
    /**
     * Other interface injections
     */
    '\WPObjects\PostType\PostTypeFactoryInterface' => array(
        'PostTypeFactory' => 'setPostTypeFactory'
    ),
    '\WPObjects\Model\ModelTypeFactoryInterface' => array(
        'ModelTypeFactory' => 'setModelTypeFactory'
    ),
    '\WPObjects\GoogleFonts\GoogleApiKeyInterface' => array(
        'google_api_key' => 'setGoogleApiKey'
    ),
    '\WPObjects\Data\DataAccessInterface' => array(
        'DataAccess' => 'setDataAccess'
    ),
    '\WPObjects\GoogleFonts\FontsFactoryInterface' => array(
        'FontsFactory' => 'setFontsFactory'
    ),
    '\WPObjects\LessCompiler\WPlessInterface' => array(
        'WPLess' => 'setWPLess'
    ),
    
);