<?php


// Antes de iniciarmos qualquer operação
// precisamos verificar se a versão do PHP
// utilizada é a versão correta. Isso é muito
// importante para manter um funcionamento
// concreto em qualquer ambiente de funcionamento
if(PHP_VERSION != '7.0.10')
    die('We sorry, we are with some problems about system version!');


// Esse bloco de código define os
// diretórios da aplicação 
define('OPERATING_SYSTEM_DIRECTORY', preg_replace('/(\/{1,})/', '/', str_replace('\\', '/', dirname(__FILE__)) . '/'));
define('SERVER_DIRECTORY', preg_replace('/(\/{1,})/', '/', preg_replace('/^\//', '', str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', OPERATING_SYSTEM_DIRECTORY))));
define('REQUEST_HOST', $_SERVER['HTTP_HOST']);
define('REQUEST_PROTOCOL', ($_SERVER['SERVER_PORT'] == 443 ? 'https' : ($_SERVER['SERVER_PORT'] == 80 ? 'http' : null)));

define('DATA_DIRECTORY', 'data/');
define('TEMPORARY_DIRECTORY', 'temporary/');
define('CORE_DIRECTORY', 'core/');
define('LIBS_DIRECTORY', 'libs/');
define('STRINGS_DIRECTORY', 'strings/');
define('INTERFACES_DIRECTORY', 'interfaces/');
define('VALIDATORS_DIRECTORY', 'validators/');
define('FORMATTERS_DIRECTORY', 'formatters/');
define('CONTROLLERS_DIRECTORY', 'controllers/');
define('HANDLERS_DIRECTORY', 'handlers/');
define('SERVICES_DIRECTORY', 'services/');
define('MODELS_DIRECTORY', 'models/');


// Esse bloco de código define os
// os headers da política de CORS
define('HEADERS_FOR_CORS', '*');
define('METHODS_FOR_CORS', '*');
define('ORIGINS_FOR_CORS', '*');


// Esse bloco de código define os
// os valores utilizados na criação
// de tokens de acesso
define('TOKEN_ISSUER', 'Arcade');
define('TOKEN_AUDIENCE', 'Arcade Applications');
define('TOKEN_EXPIRATION', 2592000);
define('TOKEN_ALGORITHM', 'HS256');
define('TOKEN_KEY', 'hincascfhçosifshafshdnvfhsadfakjsdhfkadbfsakj');
define('TOKEN_TYPE', 'JWT');


// Esse bloco de código define
// alguns valores importantes
// para o funcionamento adequado
// da aplicação
define('TIMEZONE', 'America/Sao_Paulo');
define('ALLOWED_DIRECTORIES_TO_ACCESS_DIRECTLY', ['temporary']);
define('HTTP_GET', 'GET');
define('HTTP_POST', 'POST');


// Esse bloco de código define
// as configurações de ambiente
define('LOCALHOST_ENVIRONMENT', 1);
define('TEST_ENVIRONMENT', 2);
define('PRODUCTION_ENVIRONMENT', 3);

if(preg_match('/^test.arcade.com$/', REQUEST_HOST))     define('ENVIRONMENT', TEST_ENVIRONMENT);
else if(preg_match('/^arcade.com$/', REQUEST_HOST))     define('ENVIRONMENT', PRODUCTION_ENVIRONMENT);
else                                                    define('ENVIRONMENT', LOCALHOST_ENVIRONMENT);


// Esse bloco de código define
// algumas informações sobre o
// banco de dados
define('DATABASE_CHARSET', 'utf8mb4');
define('DATABASE_NAME', 'arcade');

switch(ENVIRONMENT){
    case LOCALHOST_ENVIRONMENT:
        define('DATABASE_HOST', 'localhost');
        define('DATABASE_USERNAME', 'root');
        define('DATABASE_PASSWORD', '123456');
        
        break;
    case TEST_ENVIRONMENT:
        define('DATABASE_HOST', 'localhost');
        define('DATABASE_USERNAME', 'root');
        define('DATABASE_PASSWORD', '123456');
        break;
    case PRODUCTION_ENVIRONMENT:
        define('DATABASE_HOST', 'localhost');
        define('DATABASE_USERNAME', 'root');
        define('DATABASE_PASSWORD', '123456');
        break;
}


// Esse bloco de código define
// algumas informações sobre o
// funcionamento da aplicação
define('RESTAURANTS_PLATFORM_ID', 1);



// Esse bloco de código inicia 
// a aplicação
$status     = null;
$code       = null;
$message    = null;
$data       = null;

try
{
    include_once LIBS_DIRECTORY . 'autoloader.php';     // Vamos incluir o autoloader de bibliotecas 
    include_once CORE_DIRECTORY . 'autoloader.php';     // Vamos incluir o autoloader da aplicação
    include_once CORE_DIRECTORY . 'database.php';       // Vamos incluir o inicializador do banco de dados
    include_once STRINGS_DIRECTORY . 'default.php';     // Vamos incluir o arquivo de mensagens

    date_default_timezone_set(TIMEZONE);
    header_remove('X-Powered-By');
    header('Access-Control-Allow-Origin: ' . ORIGINS_FOR_CORS);
    header('Access-Control-Allow-Headers: ' . HEADERS_FOR_CORS);
    header('Access-Control-Allow-Methods: ' . METHODS_FOR_CORS);

    if(!REQUEST_PROTOCOL)
        throw new Exception('E010720202101');

    $status     = true;
    $code       = null;
    $message    = null;
    $data       = Router::onRequest();
}
catch(Exception $e)
{
    $status     = false;
    $code       = null;
    $data       = null;

    if(preg_match('/activerecord/i', get_class($e))){
        $code = 'E190720201514';
        
        if(ENVIRONMENT == LOCALHOST_ENVIRONMENT || ENVIRONMENT == TEST_ENVIRONMENT){
            $data = $e -> getMessage();
        }
    }
    else{
        $code = $e -> getMessage();
    }

    $message    = Strings::get($code);
}

header('Content-Type: application/json');

die(
    json_encode(
        [
            'status'    => $status,
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
        ]
    )
);

?>