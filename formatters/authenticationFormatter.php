<?php

class AuthenticationFormatter extends Formatter implements FormatterInterface
{
    public static function format_step($value){
        return intval($value);
    }
}

?>