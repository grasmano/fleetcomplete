<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 15.12.2020
 * Time: 13:52
 */
class DateHelper
{
    public static function dateDiff($date1, $date2)
    {
        $date1 = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $date1)));
        $date2 = date('Y-m-d h:i:s', strtotime(str_replace('/', '-', $date2)));

        $diff = abs(strtotime($date1) - strtotime($date2));

        $years   = floor($diff / (365*60*60*24));
        $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
        $minutes  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
        $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60));

        $array = array('years' => $years, 'months' => $months, 'days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds);

        $result = '';
        foreach ($array as $key => $value) {
            if ($value > 0) {
                $result .= ($key == 'years' || $key == 'months' || $key == 'days' || $key == 'hours' ? 'over ' : '') .  $value . ' ' . $key . ' ';
                break;
            }
        }

        return $result;
    }
}
