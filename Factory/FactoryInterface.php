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

