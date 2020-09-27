<?php

class TokensValidator extends Validator implements ValidatorInterface
{
    public static function validate_token($value, $error_message){
        if(!preg_match('/^[a-zA-Z0-9-_\.]{1,}$/', $value)) throw new Exception($error_message);
        return true;
    }
}

?>