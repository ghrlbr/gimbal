<?php

final class Globalization
{
	private $languages = null;
	private $hasError = false;
	
	
	public function HasError()
	{
		return $this -> hasError;
	}
	
	
	public function GetLanguages()
	{
		return $this -> languages;
	}
	
	
	
	public function DetectLanguages()
	{
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			if(empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) == false)
			{
				$acceptLanguagesString = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$acceptLanguagesExploded = explode(',', $acceptLanguagesString);
				$acceptLanguagesArray = array();
				
				for($i = 0; $i < count($acceptLanguagesExploded); $i++)
				{
					if(strpos($acceptLanguagesExploded[$i], ';q='))
					{
						$acceptLanguageExploded = explode(';q=', $acceptLanguagesExploded[$i]);
						
						$acceptLanguageIdentifier = $acceptLanguageExploded[0];
						$acceptLanguagePriority = $acceptLanguageExploded[1];
						
						$acceptLanguage = array('identifier' => $acceptLanguageIdentifier, 
												'priority' => $acceptLanguagePriority);
						
						array_push($acceptLanguagesArray, $acceptLanguage);
					}
					else
					{
						$acceptLanguageIdentifier = $acceptLanguagesExploded[$i];
						$acceptLanguagePriority = 1;
						
						$acceptLanguage = array('identifier' => $acceptLanguageIdentifier, 
												'priority' => $acceptLanguagePriority);
												
						array_push($acceptLanguagesArray, $acceptLanguage);
					}
				}
				
				$this -> languages = $acceptLanguagesArray;
				
				return true;
			}
			else
			{
				throw new Exception();
			}
		}
		else
		{
			throw new Exception();
		}
	}
}

?>