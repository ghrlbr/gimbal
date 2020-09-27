<?php

class AuthenticationController extends Controller implements ControllerInterface
{
    public function __construct(){
        $this -> authentication_is_required = false;
    }

    public function request_verification_code(array $data){

        if(!isset($data['params']['platform'])) throw new Exception('E110820202139');

        $platform = $data['params']['platform'];

        ApplicationValidator::validate_platform($platform, 'E120820201854');

        $platform = ApplicationFormatter::format_platform($platform);

        if($platform == CUSTOMER_PLATFORM_ID){

            if(!isset($data['params']['phone_number'])) throw new Exception('E110820202140');

            $phone_number = $data['params']['phone_number'];

            CustomersValidator::validate_phone_number($phone_number, 'E110820202141');

            $phone_number = CustomersFormatter::format_phone_number($phone_number);

            $authentication_handler = new AuthenticationHandler();
            return $authentication_handler -> send_verification_code_to_customer($phone_number);
        }
        else 
            throw new Exception('E160820201838');
    }
    public function sign_in(array $data){

        if(!isset($data['params']['platform'])) throw new Exception('E110820202139');

        $platform = $data['params']['platform'];

        ApplicationValidator::validate_platform($platform, 'E120820201854');
        
        $platform = ApplicationFormatter::format_platform($platform);

        if($platform == CUSTOMER_PLATFORM_ID){

            if(!isset($data['params']['phone_number'])) throw new Exception('E110820202140');
            if(!isset($data['params']['verification_code'])) throw new Exception('E160820201845');

            $verification_code = $data['params']['verification_code'];
            $phone_number = $data['params']['phone_number'];

            CustomersValidator::validate_verification_code($verification_code, 'E160820201846');
            CustomersValidator::validate_phone_number($phone_number, 'E110820202141');

            $verification_code = CustomersFormatter::format_verification_code($verification_code);
            $phone_number = CustomersFormatter::format_phone_number($phone_number);

            $authentication_handler = new AuthenticationHandler();
            return $authentication_handler -> sign_in_as_customer($phone_number, $verification_code);
        }
        else 
            throw new Exception('E160820201838');
    }
}

?>