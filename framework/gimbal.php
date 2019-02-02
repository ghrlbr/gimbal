<?php

namespace Gimbal
{
	RequireFile('/framework/libraries/uri.php');
	
	RequireFile('/framework/controllers/v.php');
	
	new Gimbal();
	
	final class Gimbal
	{
		private $uri;
		private $v;
		
		public function __construct()
		{
			$this -> uri = new \Libraries\Uri();
			
			$requestUri = $_SERVER['REQUEST_URI'];
			$this -> uri -> Parse($requestUri);
			
			if(empty($this -> uri -> GetParameterByIndex(0)) == false)
			{
				$filePath = '/framework/controllers/' . $this -> uri -> GetParameterByIndex(0) . '.php';
				
				if(FileExists($filePath))
				{
					RequireFile($filePath);
					
					$className = '\\Controller\\'.$this -> uri -> GetParameterByIndex(0);
					$classInstance = new $className();
				}
				else
				{
					$this -> v = new \Controller\V(false);
					$this -> v -> Show($this -> uri -> GetParameterByIndex(0));
				}
			}
			else
			{
				$this -> v = new \Controller\V(false);
				$this -> v -> Show('home');
			}
			
			return true;
		}
	}
	
	function FileExists(string $filePath)
	{
		$baseDirectory = $_SERVER['DOCUMENT_ROOT'];
		
		if(file_exists($baseDirectory.$filePath))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function RequireFile(string $filePath)
	{
		$baseDirectory = $_SERVER['DOCUMENT_ROOT'];
		
		require_once $baseDirectory.$filePath;
	}
}

?>