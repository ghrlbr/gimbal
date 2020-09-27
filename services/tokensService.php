<?php

use Ahc\Jwt\JWTException;
use Ahc\Jwt\ValidatesJWT;
use Ahc\Jwt\JWT;

class TokensService extends Service implements ServiceInterface
{
    private $token_issuer = TOKEN_ISSUER;
    private $token_expiration = TOKEN_EXPIRATION;
    private $token_audience = TOKEN_AUDIENCE;
    private $token_key = TOKEN_KEY;
    private $token_algorithm = TOKEN_ALGORITHM;

    public function validate_token(string $token) : bool {
        try
        {
            $this -> decode_token($token);
            return true;
        }
        catch(Exception $exception)
        {
            return false;
        }
    }
    public function decode_token(string $value) : stdClass {
        try
        {
            $jwt = new JWT($this -> token_key, $this -> token_algorithm, $this -> token_expiration);
            $data = $jwt -> decode($value);

            return (object) $data['sub'];
        }
        catch(Exception $exception)
        {
            throw new Exception('E190820201951');
        }
    }
    public function generate_token(array $data) : string {

        $payload['iss']     = $this -> token_issuer;
        $payload['iat']     = Time::getTimeStamp();
        $payload['exp']     = Time::getTimeStamp() + $this -> token_expiration;
        $payload['aud']     = $this -> token_audience;
        $payload['sub']     = $data;

        try
        {
            $jwt = new JWT($this -> token_key, $this -> token_algorithm, $this -> token_expiration);
            return $jwt -> encode($payload);
        }
        catch(Exception $exception)
        {
            return false;
        }
    }
}

?>