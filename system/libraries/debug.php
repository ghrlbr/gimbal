<?php

#	Name: Debug
#	Description: It allow the programmer debug your application while develop
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: October/2018
#	License: BSD


final class Debug
{
	private $report = null;
	
	
	public function GetReport()
	{
		return $this -> report;
	}
	
	
	public function MountReport($status, $code, $description, $data = null)
	{
		$header = array('status' => strtoupper($status),
						'code' => strtoupper($code),
						'description' => $description);
		$body = $data;
		
		$responseInArray = array('header' => $header, 'body' => $body);
		$responseEncodedAsJson = json_encode($responseInArray);
		
		$this -> report = $responseEncodedAsJson;
		
		return true;
	}
	
	
	
	
	
	
	
	
	
	
	
	private $warnings = array();
	
	public function Debug($status = null, $code = null, $description = null, $data = null)
	{		
		if(!empty($status) && !empty($code) && !empty($description))
		{
			$header = array('status' => strtoupper($status),
						'code' => strtoupper($code),
						'description' => $description,
						'warnings' => $this -> warnings);
						  
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

	public function WriteInConsole($status, $message)
	{
		switch(strtoupper($status))
		{
			case 'ERROR':
			
				echo '<script type="text/javascript">';
				echo 'console.error("' . $message . '");';
				echo '</script>';
			
				break;
				
			case 'WARN':
			
				echo '<script type="text/javascript">';
				echo 'console.warn("' . $message . '");';
				echo '</script>';
				
			case 'LOG':
			
				echo '<script type="text/javascript">';
				echo 'console.log("' . $message . '");';
				echo '</script>';
			
				break;
				
			default:
			
				echo '<script type="text/javascript">';
				echo 'console.log("' . $message . '");';
				echo '</script>';
			
				break;
		}
		
		return true;
	}
	public function WriteInScreen($status, $code, $description, $data = null)
	{
		$header = array('status' => strtoupper($status),
						'code' => strtoupper($code),
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

		return true;
	}
}

?>