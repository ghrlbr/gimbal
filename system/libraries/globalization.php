<?php

#	Name: Globalization
#	Description: It manages the accept languages sent by client request
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: October/2018
#	License: BSD


// This class allow the developer manages the client's accept languages easily
final class Globalization
{
	const HTTP_ACCEPT_LANGUAGE_NOT_SET = 10;	// When the client did not send the Accept-Language header
	const HTTP_ACCEPT_LANGUAGE_WITHOUT_VALUE = 20;	// When the client did send the Accept-Language header, but it is null
	const HTTP_FIRST_ACCEPT_LANGUAGE_PARSE_ERROR = 31;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
	const HTTP_SECOND_ACCEPT_LANGUAGE_PARSE_ERROR = 32;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
	const HTTP_THIRD_ACCEPT_LANGUAGE_PARSE_ERROR = 33;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
	
	
	private $firstAcceptLanguage = null;	// The first one accept language
	private $secondAcceptLanguage = null;	// The second one accept language
	private $thirdAcceptLanguage = null;	// The third one accept language
	
	
	// It returns the first one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
	public function GetFirstAcceptLanguage($data = 'IDENTIFIER')
	{
		switch(strtoupper($data))
		{
			case 'IDENTIFIER':
			
				return $this -> firstAcceptLanguage['identifier'];
			
				break;
				
			case 'PRIORITY':
			
				return $this -> firstAcceptLanguage['priority'];
			
				break;
				
			default:
			
				return $this -> firstAcceptLanguage['identifier'];
			
				break;
		}
	}
	// It returns the second one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
	public function GetSecondAcceptLanguage($data = 'IDENTIFIER')
	{
		switch(strtoupper($data))
		{
			case 'IDENTIFIER':
			
				return $this -> secondAcceptLanguage['identifier'];
			
				break;
				
			case 'PRIORITY':
			
				return $this -> secondAcceptLanguage['priority'];
			
				break;
				
			default:
			
				return $this -> secondAcceptLanguage['identifier'];
			
				break;
		}
	}
	// It returns the third one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
	public function GetThirdAcceptLanguage($data = 'IDENTIFIER')
	{
		switch(strtoupper($data))
		{
			case 'IDENTIFIER':
			
				return $this -> thirdAcceptLanguage['identifier'];
			
				break;
				
			case 'PRIORITY':
			
				return $this -> thirdAcceptLanguage['priority'];
			
				break;
				
			default:
			
				return $this -> thirdAcceptLanguage['identifier'];
			
				break;
		}
	}
	
	
	// It detects the client's first, second and third one accept language
	public function DetectAcceptLanguages()
	{
		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
			{
				$acceptLanguagesString = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
				$acceptLanguagesExploded = explode(',', $acceptLanguagesString);
				$acceptLanguages = array();
				
				for($i = 0; $i < count($acceptLanguagesExploded); $i++)
				{
					if(strpos($acceptLanguagesExploded[$i], ';q='))
					{
						$acceptLanguageExploded = explode(';q=', $acceptLanguagesExploded[$i]);
						
						$acceptLanguageIdentifier = $acceptLanguageExploded[0];
						$acceptLanguagePriority = $acceptLanguageExploded[1];
						
						$acceptLanguage = array('identifier' => $acceptLanguageIdentifier, 
												'priority' => floatval($acceptLanguagePriority));
						
						array_push($acceptLanguages, $acceptLanguage);
					}
					else
					{
						$acceptLanguageIdentifier = $acceptLanguagesExploded[$i];
						$acceptLanguagePriority = 1;
						
						$acceptLanguage = array('identifier' => $acceptLanguageIdentifier, 
												'priority' => floatval($acceptLanguagePriority));
												
						array_push($acceptLanguages, $acceptLanguage);
					}
				}
				
				if(isset($acceptLanguages[0]))
				{
					$this -> firstAcceptLanguage = array('identifier' => $acceptLanguages[0]['identifier'], 
														 'priority' => floatval($acceptLanguages[0]['priority']));
				}
				else
				{
					$this -> firstAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 1.0);
					
					throw new Exception('Was not possible parse the first client\'s accept language. The default will be used if needed.', self::HTTP_FIRST_ACCEPT_LANGUAGE_PARSE_ERROR);
				}
				
				if(isset($acceptLanguages[1]))
				{
					$this -> secondAcceptLanguage = array('identifier' => $acceptLanguages[1]['identifier'], 
														 'priority' => floatval($acceptLanguages[1]['priority']));
				}
				else
				{
					$this -> secondAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 0.9);
					
					throw new Exception('Was not possible parse the second client\'s accept language. The default will be used if needed.', self::HTTP_SECOND_ACCEPT_LANGUAGE_PARSE_ERROR);
				}
				
				if(isset($acceptLanguages[2]))
				{
					$this -> thirdAcceptLanguage = array('identifier' => $acceptLanguages[2]['identifier'], 
														 'priority' => floatval($acceptLanguages[2]['priority']));
				}
				else
				{
					$this -> thirdAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 0.8);
					
					throw new Exception('Was not possible parse the third client\'s accept language. The default will be used if needed.', self::HTTP_THIRD_ACCEPT_LANGUAGE_PARSE_ERROR);
				}
				
				return true;
			}
			else
			{
				$this -> firstAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 1.0);
				$this -> secondAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 0.9);
				$this -> thirdAcceptLanguage = array('identifier' => 'default', 
														 'priority' => 0.8);
				
				throw new Exception('The variable $_SERVER[\'HTTP_ACCEPT_LANGUAGE\'] was set, but it has not value.', self::HTTP_ACCEPT_LANGUAGE_WITHOUT_VALUE);
			}
		}
		else
		{
			$this -> firstAcceptLanguage = array('identifier' => 'default', 
												 'priority' => 1.0);
			$this -> secondAcceptLanguage = array('identifier' => 'default', 
												  'priority' => 0.9);
			$this -> thirdAcceptLanguage = array('identifier' => 'default', 
												 'priority' => 0.8);
			
			throw new Exception('The variable $_SERVER[\'HTTP_ACCEPT_LANGUAGE\'] was not set.', self::HTTP_ACCEPT_LANGUAGE_NOT_SET);
		}
	}
}

?>