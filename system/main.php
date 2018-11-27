<?php

#	Name: Gimbal
#	Description: It manages all requests made by clients
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: August/2018
#	License: BSD


// Requere todas as bibliotecas necessárias
require_once 'libraries/globalization.php';	// Requere a biblioteca Globalization
require_once 'libraries/uri.php';		// Requere a biblioteca Uri
require_once 'libraries/debug.php';	// Requere a biblioteca Debug

// Requere todos os recursos necessários
require_once 'controllers/v.php';	// Requere o controlador Views


// Instacia todas as bibliotecas requeridas
$globalization = new Globalization();
$debug = new Debug();
$uri = new Uri();

// Instacia todos os recursos requeridos
$views = new Views();


// Define o modo de funcionamento da biblioteca de depuração
$debug -> SetMode(DEBUG::DEVELOPMENT_MODE);


// Define o idioma a ser usado pelo cliente
try
{
	$globalization -> DetectAcceptLanguages();
}
catch(Exception $exception)
{
	switch($exception -> getCode())
	{
		case Globalization::HTTP_THIRD_ACCEPT_LANGUAGE_PARSE_ERROR:
		
			$debug -> WriteInConsole('WARN', 'The client\'s request contains the accept languages, but we can not parse the third one accept. The default will be used if needed.');
		
			break;
			
		case Globalization::HTTP_SECOND_ACCEPT_LANGUAGE_PARSE_ERROR:
		
			$debug -> WriteInConsole('WARN', 'The client\'s request contains the accept languages, but we can not parse the second one accept. The default will be used if needed.');
			
			break;
			
		case Globalization::HTTP_FIRST_ACCEPT_LANGUAGE_PARSE_ERROR:
		
			$debug -> WriteInConsole('WARN', 'The client\'s request contains the accept languages, but we can not parse the first one accept. The default will be used if needed.');
		
			break;
			
		case Globalization::HTTP_ACCEPT_LANGUAGE_WITHOUT_VALUE:
			
			$debug -> WriteInConsole('WARN', 'The client\'s request contains the accept languages, but it has no value. The default will be used.');
			
			break;
			
		case Globalization::HTTP_ACCEPT_LANGUAGE_NOT_SET:
		
			$debug -> WriteInConsole('WARN', 'The client\'s request does not contains the accept languages. The default will be used.');
		
			break;
			
		default:
		
			$debug -> WriteInConsole('WARN', 'It occurred an undefined error when try to detect the accept languages. The default will be used.');
			
			break;
	}
}


// Define os parâmetros da URL
try
{
	$uri -> Parse($_SERVER['REQUEST_URI']);
}
catch(Exception $exception)
{
	switch($exception -> getCode())
	{
		case Uri::REQUEST_URI_WRONG_FORMAT:
		
			$debug -> WriteInConsole('ERROR', 'The client\'s request URI was set, but it has a wrong format.');
		
			break;
			
		case Uri::REQUEST_URI_WITHOUT_VALUE:
		
			$debug -> WriteInConsole('ERROR', 'The client\'s request URI was set, but it has no value.');
		
			break;
			
		case Uri::REQUEST_URI_NOT_SET:
		
			$debug -> WriteInConsole('ERROR', 'The client\'s request URI was not set.');
		
			break;
			
		default:
		
			$debug -> WriteInConsole('ERROR', 'It occurred an undefined error when try to parse the request URL.');
		
			break;
	}
}


if(!empty($uri -> GetParameterByIndex(0)))
{
	if(file_exists("controllers/{$uri -> GetParameterByIndex(0)}.php"))
	{
		echo 'Encontrado o controlador';
	}
	else
	{
		try
		{
			$views -> Show($uri -> GetParameterByIndex(0));
		}
		catch(Exception $exception)
		{
			switch($exception -> getCode())
			{
				default:
				
					$debug -> WriteInConsole('WARN', 'It occurred an undefined error when try to detect the accept languages. The default will be used.');
					
					break;
			}
		}
	}
}
else
{
	try
	{
		$views -> Show('index');
	}
	catch(Exception $exception)
	{
		switch($exception -> getCode())
		{
			default:
			
				$debug -> WriteInConsole('WARN', 'It occurred an undefined error when try to detect the accept languages. The default will be used.');
				
				break;
		}
	}
}

?>