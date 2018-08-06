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

namespace WPObjects\Date;

class WordPress
{
    /**
     * Translated and set WordPress global timezone
     * 
     * @param type $date_string
     * @param type $format
     * @return string
     */
    public static function formatFromString($date_string, $format = 'j F Y / G:i T')
    {
        if (!$date_string || !strtotime($date_string)) {
            return '';
        }
        
        $timezone_string = \get_option('timezone_string');
        $gmt_offset = \get_option('gmt_offset');
        if ($timezone_string) {
            $tz = $timezone_string;
        } else if ($gmt_offset > 0) {
            $tz = \date('+Hi', abs($gmt_offset) * 3600);
        } else if ($gmt_offset < 0) {
            $tz = \date('-Hi', abs($gmt_offset) * 3600);
        } else {
            $tz = 'UTC';
        }

        $datetime = \date_create($date_string, new \DateTimeZone($tz));
        $timestamp = $datetime->getTimestamp();
        
        return \date_i18n($format, $timestamp);
    }
}