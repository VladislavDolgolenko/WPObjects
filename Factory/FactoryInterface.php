<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2017 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
 */

namespace WPObjects\Factory;

interface FactoryInterface
{
    /**
     * Do query by id and filters, return one model result
     * 
     * @param type $id
     * @param type $filters
     * @param type $single
     * 
     * @return object|array
     */
    public function get($id = null, $filters = array(), $single = true);

    /**
     * Do query by filter params
     * 
     * @param type $filters
     * @param type $result_as_object
     * 
     * @return $this
     */
    public function query($filters = array(), $result_as_object = false);
    
    /**
     * Return models from last query result
     * 
     * @return array
     */
    public function getResult();
    
    /**
     * Return one model from last query result
     * 
     * @return object|array
     */
    public function getOneResult();
    
    /**
     * Return models identities from last query result
     * 
     * @return array 
     */
    public function getResultIds();
}

