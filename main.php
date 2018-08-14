<?php


# Global Variables
$uri = null;		// It storages the request URI
$language = null;		// It storages the browser language


# It process the request URI
$requestedUri = $_SERVER['REQUEST_URI'];		// It returns the requested URI
$explodedUri = explode('/', $requestedUri);		// It explodes the requested URI in each '/'
$filteredUri = array_filter($explodedUri);		// It removes the empty elements from explodedUri variable
$reindexedUri = array_values($filteredUri);		// It re-indexes the elements of filteredUri variable
$uri = $reindexedUri;		// It re-allocates the reindexedUri to other variable


# It process the browser language
$browserPreferredLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];		// It returns the browser preferred language
$browserPreferredLanguage = substr($browserPreferredLanguages, 0, strpos($browserPreferredLanguages, ','));
$language = $browserPreferredLanguage;


###################### IMPORTANT ACTIONS #####################################################################
##																											##
## FAZER A VERIFICAÇÃO DOS DADOS $_SERVER['REQUEST_URI'] E $_SERVER['HTTP_ACCEPT_LANGUAGE'] UTILIZANDO		##
## EXPRESSÕES REGULARES ANTES DE UTILIZA-LOS.																##
##																											##
## NÍVEL DE NECESSIDADE: URGENTE.																			##
##																											##
###################### IMPORTANT ACTIONS #####################################################################






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

?>