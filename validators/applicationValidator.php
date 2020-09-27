<?php

class ApplicationValidator extends Validator implements ValidatorInterface
{
    public static function validate_platform($value, $error_message){
        if(!preg_match('/^[0-9]{1,}$/', $value)) throw new Exception($error_message);
        return true;
    }
}

?>