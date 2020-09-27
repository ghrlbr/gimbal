<?php

class TokensFormatter extends Formatter implements FormatterInterface
{
    public static function format_token($value){
        return strval($value);
    }
}

?>