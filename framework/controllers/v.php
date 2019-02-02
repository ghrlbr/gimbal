<?php

namespace Controller
{
	\Gimbal\RequireFile('/framework/libraries/uri.php');
	\Gimbal\RequireFile('/framework/libraries/globalization.php');

	final class V
	{
		private $globalization;
		
		public function __construct(bool $autoInitialize = true)
		{
			$uri = new \Libraries\Uri();
			$this -> globalization = new \Libraries\Globalization();
			
			$requestUri = $_SERVER['REQUEST_URI'];
			$uri -> Parse($requestUri);
			
			$this -> globalization -> DetectAcceptLanguages();
			
			if($autoInitialize)
			{
				if(empty($uri -> GetParameterByIndex(1)))
				{
					$this -> Show('home');
					
					return true;
				}
				else
				{
					$this -> Show($uri -> GetParameterByIndex(1));
					
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		
		public function Show(string $name)
		{
			if(!empty($this -> globalization -> GetFirstAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)))
			{
				if(\Gimbal\FileExists("/application/frontend/structures/{$this -> globalization -> GetFirstAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)}/$name.html"))
				{
					\Gimbal\RequireFile("/application/frontend/structures/{$this -> globalization -> GetFirstAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)}/$name.html");
				}
				else
				{
					if(!empty($this -> globalization -> GetSecondAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)))
					{
						if(\Gimbal\FileExists("/application/frontend/structures/{$this -> globalization -> GetSecondAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)}/$name.html"))
						{
							\Gimbal\RequireFile("/application/frontend/structures/{$this -> globalization -> GetSecondAcceptLanguage(\Libraries\Globalization::LANGUAGE_IDENTIFIER)}/$name.html");
						}
						else
						{
							if(\Gimbal\FileExists("/application/frontend/structures/default/$name.html"))
							{
								\Gimbal\RequireFile("/application/frontend/structures/default/$name.html");
							}
							else
							{
								$this -> Show('404');
							}
						}
					}
					else
					{
						if(\Gimbal\FileExists("/application/frontend/structures/default/$name.html"))
						{
							\Gimbal\RequireFile("/application/frontend/structures/default/$name.html");
						}
						else
						{
							$this -> Show('404');
						}
					}
				}
			}
			else
			{
				if(\Gimbal\FileExists("/application/frontend/structures/default/$name.html"))
				{
					\Gimbal\RequireFile("/application/frontend/structures/default/$name.html");
				}
				else
				{
					$this -> Show('404');
				}
			}
		}
	}
}

?>