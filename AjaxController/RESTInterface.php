<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2016 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko (vladislavdolgolenko.com)
 * @support      support@torbara.com
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