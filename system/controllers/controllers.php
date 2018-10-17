<?php

final class Controllers
{
	public final function Controllers()
	{
		global $uri;
		
		if(isset($uri[1]))
		{
			if(file_exists('application/controllers/'.$uri[1].'.php'))
			{
				require_once 'application/controllers/'.$uri[1].'.php';
				
				$controllerName = $uri[1];
				$controllerInstance = new $controllerName();
			}
			else
			{
				$response = null;
				
				$head = array(	'status' => 'ERROR', 
								'type' => 'REQUESTMENT',
								'code' => 'NF404181617102018',
								'description' => 'Requested controller was not found');
				
				$response = array('head' => $head);
				
				$response = json_encode($response);
				
				echo $response;
				
				header('content-type: application/json');
			}
		}
		else
		{
			$response = null;
			
			$head = array(	'status' => 'ERROR', 
							'type' => 'REQUESTMENT',
							'code' => 'BR400X173417102018',
							'description' => 'Any controller was set before to request the server');
			
			$response = array('head' => $head);
			
			$response = json_encode($response);
			
			echo $response;
			header('content-type: application/json');
		}
	}
}

?>