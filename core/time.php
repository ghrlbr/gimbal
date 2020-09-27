<?php

class Time
{
    public static function getTimeStamp()
    {
        return strtotime(date('Y-m-d H:i:s'));
    }
    public static function getDateTime()
    {
        return date('Y-m-d H:i:s');
    }
}

?>