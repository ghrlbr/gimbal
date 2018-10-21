<?php

// Essas são as variáveis globais, elas armazenarão valores que podem ser usados em toda aplicação
$uri = null;	// Essa variável armazena os dados passados pela URI em forma de array
$language = null;	// Essa variável armazena o idioma preferido do navegador de acesso em forma de string



// Essa bloco de código define o valor da variável global $uri
if(isset($_SERVER['REQUEST_URI']))
{
	if(empty($_SERVER['REQUEST_URI']) == false)
	{
		$requestedUri = $_SERVER['REQUEST_URI'];	// Retorna a URI requisitada
		$explodedUri = explode('/', $requestedUri);	// Divide a URI a cada "/"
		$filteredUri = array_filter($explodedUri);	// Remove os elementos vazios
		$reindexedUri = array_values($filteredUri);	// Re-indexa os elementos
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
if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
{
	if(empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) == false)
	{
		$preferredLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];	// Retorna os idiomas preferido do navegador em forma de string
		$preferredLanguage = substr($preferredLanguages, 0, strpos($preferredLanguages, ','));	// Retorna o idioma preferido do navegador em forma de string
		$preferredLanguage = strtolower($preferredLanguage);
		
		if(preg_match('/^([a-z]{1,3}-[A-Z]{1,3}|[a-z]{1,3})$/i', $preferredLanguage))
		{
			$language = $preferredLanguage;	// Armazena o idioma preferido do navegador em forma de string
		}
		else
		{
			$language = 'default';
			
			WriteInConsole('O formato do idioma preferido pelo navegador não corresponde a um padrão já estabelecido. O idioma padrão será utilizado.', 'WARN');
		}
	}
	else
	{
		$language = 'default';
		
		WriteInConsole('A requisição definiu um valor nulo para o idioma preferido do navegador. O idioma padrão será utilizado.', 'WARN');
	}
}
else
{
	$language = 'default';
	
	WriteInConsole('A requisição enviada não definiu nenhum idioma preferido pelo navegador. O idioma padrão será utilizado', 'WARN');
}



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