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

namespace WPObjects\AjaxController;

interface RESTInterface
{
    public function get($id);
    
    public function getList($params = null);
    
    public function update($id, $data);
    
    public function create($data);
    
    public function delete($id);
}