<?php

require_once 'system/helpers/database.php';

final class Users
{
	private $username;
	private $password;
	
	private $database;
	
	public final function Users()
	{
		switch(strtoupper($_SERVER['REQUEST_METHOD']))
		{
			case 'POST':
				
				if(isset($_POST['username']))
				{
					// Verifica os dados enviados
					
					$this -> username = $_POST['username'];
					
					if(isset($_POST['password']))
					{
						// Verifica os dados enviados

						$this -> password = $_POST['password'];
						
						$database = new Database();
						$database -> SetUsername('root');
						$database -> SetPassword('');
						
						try
						{
							$database -> Connect();
						}
						catch(Exception $exception)
						{
							echo 'NÃO DEU PRA CONECTAR NO DB';
						}
						
						try
						{
							$database -> Query("SELECT `username` FROM `users` WHERE `username` = '{$this -> username}' AND `password` = '{$this -> password}'");
						}
						catch(Exception $exception)
						{
							echo 'NÃO DEU PRA CONSULTAR O DB';
						}
						
						if($database -> GetQuery() == false)
						{
							try
							{
								$database -> Query("INSERT INTO `users` (`username`, `password`) VALUES ('{$this -> username}', '{$this -> password}')");
							}
							catch(Exception $exception)
							{
								echo 'NÃO DEU PRA CADASTRAR N';
							}
							
							echo 'usuário registrado';
						}
						else
						{
							echo 'USERNAME JÁ EM USO';
						}
					}
					else
					{
							echo 'password not sent';
					}
				}
				else
				{
					echo 'username not sent';
				}
					
			break;
		}
	}
}

?>