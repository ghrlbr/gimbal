<?php

#	Name: Debug
#	Description: It allow the programmer debug your application while develop
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: October/2018
#	License: BSD


final class Debug
{
	private $warnings = array();
	
	public function Debug($status = null, $code = null, $description = null, $data = null)
	{		
		if(!empty($status) && !empty($code) && !empty($description))
		{
			$header = array('status' => $status,
						  'code' => $code,
						  'description' => $description);
						  
			$body = $data;
			
			$responseInArray = array('header' => $header,
							  'body' => $body);
							  
			$responseEncodedAsJson = json_encode($responseInArray);
			
			header('Content-Type: application/json');
			
			echo $responseEncodedAsJson;
			
			return true;
		}
		else
		{
			return true;
		}
	}
	
	public function AddWarning($message)
	{
		array_push($this -> warnings , $message);
	}
	public function Write($status, $code, $description, $data = null)
	{
		$header = array('status' => $status,
						'code' => $code,
						'description' => $description,
						'warnings' => $this -> warnings);
		$body = $data;
		
		$responseInArray = null;
		
		if(!empty($body))
		{
			$responseInArray = array('header' => $header, 'body' => $body);
		}
		else
		{
			$responseInArray = array('header' => $header);
		}
		
		$responseEncodedAsJson = json_encode($responseInArray);
		
		header('Content-Type: application/json');
		
		echo $responseEncodedAsJson;
		
		exit;
	}
}

?>