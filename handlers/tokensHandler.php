<?php

class TokensHandler extends Handler implements HandlerInterface
{
    public function generate_token(array $data) : string {
        $tokens_service = new TokensService();
        return $tokens_service -> generate_token($data);
    }
    public function validate_token(string $token) : bool {
        $tokens_service = new TokensService();
        return $tokens_service -> validate_token($token);
    }
    public function decode_token(string $token) : stdClass {
        $tokens_service = new TokensService();
        return $tokens_service -> decode_token($token);
    }
}

?>