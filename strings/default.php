<?php

class Strings
{
    public static function get($id){
        $strings = [
            'E160820201931' => 'Não foi possível cadastrar ou encontrar o usuário para enviar o código de verificação',
            'E160820201933' => 'Não foi possível salvar o código de verificação do usuário',
            'E160820201936' => 'Não foi possível encontrar o usuário',
            'E160820201934' => 'Problemas ao enviar sms',
            'E170820202049' => 'Problemas ao gerar token',
            'E190820201926' => 'invalid token',
            'E190820201951' => 'erro ao decodificar token',
            'E190820201954' => 'token invalido', 
            'E160820201846' => 'You need send a valid verification code',
            'E110820202141' => 'You need send a valid phone number',
            'E110820202140' => 'You need send a phone number',
            'E160820201845' => 'You need send a verification code',
            'E160820201920' => 'Código de verificação errado',
            'E160820201929' => 'Usuário não cadastrado',
            'E190820201924' => 'You need send a token',
            'E110820202139' => 'You need specify what platform are you using',
            'E160820201838' => 'Unknown platform specified',
            'E120820201854' => 'You need send a valid platform',
            'E130620201950' => 'Problems to define application environment.',
            'E010720202101' => 'You need access the application using 80 or 443 port',
            'E010720202120' => 'Internal error to copy file to temporary folder',
            'E130620200831' => 'You need set an endpoint in your request.',
            'E130620200832' => 'The endpoint was not found.',
            'E130620200833' => 'The requested method was not found in this endpoint.',
            'E130620200840' => 'Not implemented.',
            'E130620200837' => 'Problems to get data from database.',
            'E130620200836' => 'Can not connect to database.',
            'E190720201514' => 'Problems to execute query',
        ];

        if(isset($strings[$id]))
            return $strings[$id];
        return null;
    }
}

?>