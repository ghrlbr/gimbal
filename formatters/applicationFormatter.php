<?php

class ApplicationFormatter extends Formatter implements FormatterInterface
{
    public static function format_platform($value){
        return intval($value);
    }
}

?>