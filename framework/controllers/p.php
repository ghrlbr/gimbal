<?php

namespace Controller
{
	\Gimbal\RequireFile('/framework/libraries/uri.php');
	\Gimbal\RequireFile('/framework/libraries/debug.php');
	
	final class P
	{		
		public function __construct(bool $autoInitialize = true)
		{
			$uri = new \Libraries\Uri();
			$debug = new \Libraries\Debug();
			
			$requestUri = $_SERVER['REQUEST_URI'];
			$uri -> Parse($requestUri);
			
			if($autoInitialize)
			{
				if(empty($uri -> GetParameterByIndex(1)))
				{
					$debug -> WriteInScreen(
						'ERROR',
						'p165031012019',
						'You need set a plugin to call.'
					);
					
					return false;
				}
				else
				{
					if(\Gimbal\FileExists('/application/backend/plugins/' . $uri -> GetParameterByIndex(1) . '.php'))
					{
						\Gimbal\RequireFile('/application/backend/plugins/' . $uri -> GetParameterByIndex(1) . '.php');
					
						$className = '\\Plugins\\' . $uri -> GetParameterByIndex(1);
						$classInstance = new $className();
					}
					else
					{
						$debug -> WriteInScreen(
							'ERROR',
							'p165631012019',
							'The setted plugin do not exists.'
						);
					}
				}
			}
			else
			{
				return true;
			}
		}
	}
}

?>