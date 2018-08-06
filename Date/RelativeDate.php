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

/**
 * @link https://gist.github.com/haqu/181590
 * @author haqu https://gist.github.com/
 */
class RelativeDate {

    public static function pluralize($count, $word)
    {
        if ($count == 0) {
            return "no " . $word . "s";
        } else if ($count == 1) {
            return "1 " . $word;
        } else {
            return floor($count) . " " . $word . "s";
        }
    }

    public static function date_diff($interval, $date1, $date2)
    {

        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $seconds = $date2 - $date1;
        if ($seconds < 0) {
            $tmp = $date1;
            $date1 = $date2;
            $date2 = $tmp;
            $seconds = 0 - $seconds;
        }
        if ($interval == 'y' || $interval == 'm') {
            $date1 = date("Y-m-d h:i:s", $date1);
            $date2 = date("Y-m-d h:i:s", $date2);
        }
        switch ($interval) {
            case "y":
                list($year1, $month1, $day1) = array_pad( explode('-', $date1), 3, 0);
                list($year2, $month2, $day2) = array_pad( explode('-', $date2), 3, 0);
                $time1 = (date('H', (int)$date1) * 3600) + (date('i', (int)$date1) * 60) + (date('s', (int)$date1));
                $time2 = (date('H', (int)$date2) * 3600) + (date('i', (int)$date2) * 60) + (date('s', (int)$date2));
                $diff = $year2 - $year1;
                if ($month1 > $month2) {
                    $diff -= 1;
                } elseif ($month1 == $month2) {
                    if ($day1 > $day2) {
                        $diff -= 1;
                    } elseif ($day1 == $day2) {
                        if ($time1 > $time2) {
                            $diff -= 1;
                        }
                    }
                }
                break;
            case "m":
                list($year1, $month1, $day1) = array_pad( explode('-', $date1), 3, 0);
                list($year2, $month2, $day2) = array_pad( explode('-', $date2), 3, 0);
                $time1 = (date('H', (int)$date1) * 3600) + (date('i', (int)$date1) * 60) + (date('s', (int)$date1));
                $time2 = (date('H', (int)$date2) * 3600) + (date('i', (int)$date2) * 60) + (date('s', (int)$date2));
                $diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
                if ($day1 > $day2) {
                    $diff -= 1;
                } elseif ($day1 == $day2) {
                    if ($time1 > $time2) {
                        $diff -= 1;
                    }
                }
                break;
            case "w":
                $diff = floor($seconds / 604800);
                break;
            case "d":
                $diff = floor($seconds / 86400);
                break;
            case "h":
                $diff = floor($seconds / 3600);
                break;
            case "i":
                $diff = floor($seconds / 60);
                break;
            case "s":
                $diff = $seconds;
                break;
        }
        return $diff;
    }

    public static function parse($date_added)
    {
        $now = date('Y-m-d H:i:s');
        $hours_ago = self::date_diff('h', $now, $date_added);

        if ($hours_ago < 1) {
            $min_ago = self::date_diff('i', $now, $date_added);
            if ($min_ago < 1) {
                $sec_ago = self::date_diff('s', $now, $date_added);
                if ($sec_ago < 1) {
                    $ago = "just now";
                } else {
                    $ago = self::pluralize($sec_ago, "second") . " ago";
                }
            } else {
                $ago = self::pluralize($min_ago, "minute") . " ago";
            }
        } elseif ($hours_ago > 743) {
            $months_ago = self::date_diff('m', $now, $date_added);
            $ago = self::pluralize($months_ago, "month") . " ago";
        } elseif ($hours_ago > 23) {
            $days_ago = self::date_diff('d', $now, $date_added);
            if ($days_ago == 1) {
                $ago = "yesterday";
            } else {
                $ago = $days_ago . " days ago";
            }
        } else {
            $ago = self::pluralize($hours_ago, "hour") . " ago";
        }

        return $ago;
    }

}
