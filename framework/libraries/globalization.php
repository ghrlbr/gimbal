<?php

#	Name: Globalization
#	Description: It manages the accept languages sent by client request
#	Author: Gabriel Henrique
#	Username: @ghrlbr
#	Date: October/2018
#	License: BSD


namespace Libraries
{
	// This class allow the developer manages the client's accept languages easily
	final class Globalization
	{
		const HTTP_ACCEPT_LANGUAGE_NOT_SET = 10;	// When the client did not send the Accept-Language header
		const HTTP_ACCEPT_LANGUAGE_WITHOUT_VALUE = 20;	// When the client did send the Accept-Language header, but it is null
		const HTTP_FIRST_ACCEPT_LANGUAGE_PARSE_ERROR = 31;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
		const HTTP_SECOND_ACCEPT_LANGUAGE_PARSE_ERROR = 32;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
		const HTTP_THIRD_ACCEPT_LANGUAGE_PARSE_ERROR = 33;	// When the Accept-Language format is incorrect, so we can not detect the client's accept languages
		
		const LANGUAGE_IDENTIFIER = 'IDENTIFIER';
		const LANGUAGE_PRIORITY = 'PRIORITY';
		
		private $firstAcceptLanguage = null;	// The first one accept language
		private $secondAcceptLanguage = null;	// The second one accept language
		private $thirdAcceptLanguage = null;	// The third one accept language
		
		
		// It returns the first one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
		public function GetFirstAcceptLanguage(string $selector)
		{
			switch($selector)
			{
				case self::LANGUAGE_IDENTIFIER:
				
					return $this -> firstAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
					break;
					
				case self::LANGUAGE_PRIORITY:
				
					return $this -> firstAcceptLanguage[self::LANGUAGE_PRIORITY];
				
					break;
					
				default:
				
					return $this -> firstAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
					break;
			}
		}
		// It returns the second one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
		public function GetSecondAcceptLanguage(string $selector)
		{
			switch($selector)
			{
				case self::LANGUAGE_IDENTIFIER:
				
					return $this -> secondAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
					break;
					
				case self::LANGUAGE_PRIORITY:
				
					return $this -> secondAcceptLanguage[self::LANGUAGE_PRIORITY];
				
					break;
					
				default:
				
					return $this -> secondAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
					break;
			}
		}
		// It returns the third one accept language, send as first parameter 'IDENTIFIER' to get the language identifier, or 'PRIORITY' to get the language priority
		public function GetThirdAcceptLanguage(string $selector)
		{
			switch($selector)
			{
				case self::LANGUAGE_IDENTIFIER:
				
					return $this -> thirdAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
					break;
					
				case self::LANGUAGE_PRIORITY:
				
					return $this -> thirdAcceptLanguage[self::LANGUAGE_PRIORITY];
				
					break;
					
				default:
				
					return $this -> thirdAcceptLanguage[self::LANGUAGE_IDENTIFIER];
				
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
					$stringedAcceptLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
					$explodedAcceptLanguages = explode(',', $stringedAcceptLanguages);
					$acceptLanguages = array();
					
					for($i = 0; $i < count($explodedAcceptLanguages); $i++)
					{
						if(strpos($explodedAcceptLanguages[$i], ';q='))
						{
							$acceptLanguageExploded = explode(';q=', $explodedAcceptLanguages[$i]);
							
							$acceptLanguageIdentifier = $acceptLanguageExploded[0];
							$acceptLanguagePriority = $acceptLanguageExploded[1];
							
							$acceptLanguage = array(self::LANGUAGE_IDENTIFIER => $acceptLanguageIdentifier, 
													self::LANGUAGE_PRIORITY => floatval($acceptLanguagePriority));
							
							array_push($acceptLanguages, $acceptLanguage);
						}
						else
						{
							$acceptLanguageIdentifier = $explodedAcceptLanguages[$i];
							$acceptLanguagePriority = 1;
							
							$acceptLanguage = array(self::LANGUAGE_IDENTIFIER => $acceptLanguageIdentifier, 
													self::LANGUAGE_PRIORITY => floatval($acceptLanguagePriority));
													
							array_push($acceptLanguages, $acceptLanguage);
						}
					}
					
					if(isset($acceptLanguages[0]))
					{
						$this -> firstAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => $acceptLanguages[0][self::LANGUAGE_IDENTIFIER], 
															 self::LANGUAGE_PRIORITY => floatval($acceptLanguages[0][self::LANGUAGE_PRIORITY]));
					}
					else
					{
						$this -> firstAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
															 self::LANGUAGE_PRIORITY => 1.0);
					}
					
					if(isset($acceptLanguages[1]))
					{
						$this -> secondAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => $acceptLanguages[1][self::LANGUAGE_IDENTIFIER], 
															  self::LANGUAGE_PRIORITY => floatval($acceptLanguages[1][self::LANGUAGE_PRIORITY]));
					}
					else
					{
						$this -> secondAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
															  self::LANGUAGE_PRIORITY => 0.9);
					}
					
					if(isset($acceptLanguages[2]))
					{
						$this -> thirdAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => $acceptLanguages[2][self::LANGUAGE_IDENTIFIER], 
															 self::LANGUAGE_PRIORITY => floatval($acceptLanguages[2][self::LANGUAGE_PRIORITY]));
					}
					else
					{
						$this -> thirdAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
															 self::LANGUAGE_PRIORITY => 0.8);
					}
					
					return true;
				}
				else
				{
					$this -> firstAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
														 self::LANGUAGE_PRIORITY => 1.0);
					$this -> secondAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
														  self::LANGUAGE_PRIORITY=> 0.9);
					$this -> thirdAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
														 self::LANGUAGE_PRIORITY => 0.8);
				}
			}
			else
			{
				$this -> firstAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
													 self::LANGUAGE_PRIORITY => 1.0);
				$this -> secondAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
													  self::LANGUAGE_PRIORITY => 0.9);
				$this -> thirdAcceptLanguage = array(self::LANGUAGE_IDENTIFIER => 'default', 
													 self::LANGUAGE_PRIORITY => 0.8);
			}
		}
	}
}


?>