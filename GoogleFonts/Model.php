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

namespace WPObjects\GoogleFonts;

class Model extends \WPObjects\Model\AbstractDataModel
{
    public function getId()
    {
        return $this->get('family');
    }
    
    public function getName()
    {
        return $this->get('family');
    }
}