<?php

class Validator
{
    public static function validate_id($value, string $exceptionMessage) : bool {
        if(!is_numeric($value)) throw new Exception($exceptionMessage);
        return true;
    }
}

?>