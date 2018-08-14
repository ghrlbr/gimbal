<?php

final class Controllers
{
	public final function Controllers()
	{
		global $_URI;
		
		if(isset($_URI[1]))
		{
			if(file_exists('application/controllers/'.$_URI[1].'.php'))
			{
				require_once 'application/controllers/'.$_URI[1].'.php';
				
				$controllerName = $_URI[1];
				$controllerInstance = new $controllerName();
			}
			else
			{
				echo 'controller doesnt exists';
			}
		}
		else
		{
			echo 'controller not set';
		}
	}
}

?>