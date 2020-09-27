<?php

class CustomersFormatter extends Formatter implements FormatterInterface
{
    public static function format_verification_code($value){
        return strval($value);
    }
    public static function format_phone_number($value){
        return strval($value);
    }
}

?>