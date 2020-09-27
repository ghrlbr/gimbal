<?php

class Controller
{
    public $authentication_is_required = true;
    
    public function __construct(array $data){

        if($this -> authentication_is_required){

            $this -> validate_token($data);
            $token_payload = $this -> decode_token($data);
    
            $this -> apply_to_this_token_payload($token_payload);
        }
    }
    public function validate_token(array $data) : bool {

        if(!isset($data['params']['token'])) throw new Exception('E190820201924');

        $token = $data['params']['token'];

        TokensValidator::validate_token($token, 'E190820201926');

        $token = TokensFormatter::format_token($token);

        $tokens_handler = new TokensHandler();
        $is_valid = $tokens_handler -> validate_token($token);

        if(!$is_valid)
            throw new Exception('E190820201954');

        return true;
    }
    public function decode_token(array $data) : stdClass {

        if(!isset($data['params']['token'])) throw new Exception('E190820201924');

        $token = $data['params']['token'];

        TokensValidator::validate_token($token, 'E190820201926');

        $token = TokensFormatter::format_token($token);

        $tokens_handler = new TokensHandler();
        return $tokens_handler -> decode_token($token);
    }

    private function apply_to_this_token_payload(stdClass $token_payload){

        foreach ($token_payload as $key => $value) {
            $renamed_key = 'token_' . $key;
            $this -> $renamed_key = $value;
        }
    }
}

?>