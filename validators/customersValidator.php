<?php

class CustomersValidator extends Validator implements ValidatorInterface
{
    public static function validate_phone_number($value, $error_message){
        if(!preg_match('/^[0-9]{11}$/', $value)) throw new Exception($error_message);
        return true;
    }
    public static function validate_verification_code($value, $error_message){
        if(!preg_match('/^([0-9]{4})$/', $value)) throw new Exception($error_message);
        return true;
    }
}

?>