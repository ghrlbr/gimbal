<?php

require_once 'system/helpers/globalization.php';



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
$globalization = new Globalization();

try
{
	$globalization -> DetectLanguages();
	$languages = $globalization -> GetLanguages();
	$language = $language[0]['identifier'];
}
catch(Exception $e)
{
	$language = 'default';
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