<?php

# Matéria excelente sobre download de arquivos através do PHP
# https://www.media-division.com/the-right-way-to-handle-file-downloads-in-php/

final class Files
{
	public final function Files()
	{
		global $uri;
		
		if(isset($uri[1]))
		{
			if($this -> Exists($uri[1]))
			{
				$this -> Download($uri[1]);
			}
			else
			{
				echo 'Esse arquivo n existe';
				
				return;
			}
		}
		else
		{
			echo 'tá faltando o nome do arquivo mula';
			
			return;
		}
	}
	
	private final function Exists(string $filename)
	{
		$filePath = "application/files/$filename";
		
		if(file_exists($filePath))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	private final function Download(string $filename)
	{
		$originalFilename = $filename;
		$sanitizedFilename = pathinfo($originalFilename);
		
		$filePath = "application/files/{$sanitizedFilename['basename']}";
	
		header('Content-Type: application/octet-stream');
		header("Accept-Ranges: bytes");
		
		set_time_limit(0);
		
		$file = fopen($filePath, 'r');
		
		while(!feof($file))
		{
			print(fread($file, 1024 * 8));
			ob_flush();
			flush();
		}
		
		return;
	}
}

?>