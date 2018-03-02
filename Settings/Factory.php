<?php

/**
 * @encoding     UTF-8
 * @copyright    Copyright (C) 2018 Torbara (http://torbara.com). All rights reserved.
 * @license      Envato Standard License http://themeforest.net/licenses/standard?ref=torbara
 * @author       Vladislav Dolgolenko <vladislavdolgolenko.com>
 * @support      support@torbara.com
 */

namespace WPObjects\Settings;

use WPObjects\Settings\Model;

class Factory extends \WPObjects\Factory\AbstractData
{
    public function initModel($data)
    {
        $SettingModel = new Model($data);
        return $this->getServiceManager()->inject($SettingModel);
    }
}