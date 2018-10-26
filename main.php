<?php

#	Name: Gimbal
#	Description: It manages all requests made by clients
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: August/2018
#	License: BSD


// Requere todas as bibliotecas necessárias
require_once 'system/libraries/globalization.php';	// Requere a biblioteca Globalization
require_once 'system/libraries/url.php';		// Requere a biblioteca Url
require_once 'system/libraries/debug.php';	// Requere a biblioteca Debug


// Instacia todas as bibliotecas requeridas
$globalization = new Globalization();
$url = new Url();
$debug = new Debug();


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


// -------------------------------- CÓDIGO REFATORADO ATÉ AQUI


// Essa bloco de código define o valor da variável global $uri
if(isset($_SERVER['REQUEST_URI']))
{
	if(empty($_SERVER['REQUEST_URI']) == false)
	{
		$requestedUri = $_SERVER['REQUEST_URI'];	// Retorna a URI requisitada
		$explodedUri = explode('/', $requestedUri);	// Divide a URI a cada "/"
		$filteredUri = array_filter($explodedUri);	// Remove os elementos vazios
		$reindexedUri = array_values($filteredUri);	// Re-indexa os elementos
		
		for($i = 0; $i < count($reindexedUri); $i++)
		{
			$reindexedUri[$i] = urldecode($reindexedUri[$i]);
			
		}
		
		$uri = $reindexedUri;	// Armazena os dados passados pela URI em forma de array
	}
	else
	{
		$uri = array('v', 'index');
		
		WriteInConsole('A requisição enviada possui uma URI nula. A página index será retornada.');
	}
}
else
{
	$uri = array('v', 'index');
	
	WriteInConsole('A requisição não definiu uma URI. A página index será retornada.');
}


// Essa bloco de código define o valor da variável global $uri
$language = $globalization -> GetFirstAcceptLanguage();


if(isset($uri[0]))		// Verifica se o parâmetro principal foi definido
{
	switch($uri[0])		// Mostra conteúdos diferentes de acordo com o parâmetro enviado ('v' = views; 'c' = controllers; 'f' = files)
	{
		case 'f':
			
			require_once 'system/controllers/files.php';		// Request necessary files class
				
			$filesInstance = new Files();
			
			break;
			
		case 'v':
			
			require_once 'system/controllers/views.php';		// Request necessary views class
			
			$viewsInstance = new Views();
				
			break;
				
		case 'c':
			
			require_once 'system/controllers/controllers.php';		// Request necessary controller class
				
			$controllersInstance = new Controllers();
			
			break;
				
		default:		// Se o parâmetro principal não for um disponível, tenta procurar por uma página com o mesmo valor do parâmetro
			
			$uri = array('v', $uri[0]);
			
			require_once 'system/controllers/views.php';		// Request necessary views class
					
			$viewsInstance = new Views();
			
			break;
	}
}
else		// Caso não, cria-se os parâmetros para funcionamento padrão
{
	$uri = array('v', 'index');
	
	require_once 'system/controllers/views.php';		// Request necessary views class
			
	$viewsInstance = new Views();
}

function WriteInConsole(string $string, $type = 'LOG')
{
	switch(strtoupper($type))
	{
		case 'ERROR':
		
			echo '<script>console.error("' . $string . '");</script>';
		
			break;
			
		case 'WARN':
		
			echo '<script>console.warn("' . $string . '");</script>';
		
			break;
			
		case 'LOG':
		
			echo '<script>console.log("' . $string . '");</script>';
		
			break;
			
		default:
		
			echo '<script>console.log("' . $string . '");</script>';
		
			break;
	}
}

?>