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

namespace WPObjects\Customizer\Preset;

interface PresetsInterface
{
    /**
     * @return \WPObjects\VC\AddonPreset\Model
     */
    public function getPresets();
    
    public function setPresets($Presets);
}