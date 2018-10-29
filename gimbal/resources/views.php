<?php

final class Views
{
	public function Show(string $name)
	{
		throw new Exception('');
	}
	
	
	/*
	
	
	
	public final function Views()
	{
		
		
		
		
		
		
		return false;
		
		global $uri;		// It storages the uri
		global $language;		// It storages the user's browser language
		
		if(isset($uri[1]))		// It storages the view name, so we need check if it is set
		{
			if($this -> Exists($uri[1]))		// Before to show a view, we need check if it exists
			{
				http_response_code(304);
				$this -> Show($uri[1]);
				
				return;
			}
			else		// Case not, show Not found view (404 in HTTP error code)
			{
				if($this -> Exists('404'))		// But, firstly we need check if this view exists
				{
					$this -> Show('404');
					
					return;
				}
				else		// Case not, we show just a simple text
				{
					echo 'NF404X165317102018';
					
					return;
				}
			}
		}
		else		// Case not, we need show the Bad request view (400 in HTTP error code)
		{
			if($this -> Exists('400'))		// But, firstly we need check if this view exists
			{
				$this -> Show('400');
				
				return;
			}
			else		// Case not, we show just a simple text
			{
				echo 'Bad request';
			
				return;
			}
		}
	}
	
	private final function Exists(string $viewName)		// It checks if the view exists in /application/views/structures/
	{
		global $language;		// It storages the user's browser language
		
		$browserLanguageViewPath = "application/views/structures/$language/$viewName.html";
		$defaultLanguageViewPath = "application/views/structures/default/$viewName.html";
		
		if(file_exists($browserLanguageViewPath))
		{
			return true;
		}
		else
		{
			if(file_exists($defaultLanguageViewPath))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	private final function Show(string $viewName)
	{
		global $uri;		// It storages the uri
		global $language;		// It storages the user's browser language
		
		$browserLanguageViewPath = "application/views/structures/$language/$viewName.html";
		$defaultLanguageViewPath = "application/views/structures/default/$viewName.html";
		$selectedLanguageViewPath = null;
		
		if(file_exists($browserLanguageViewPath))
		{
			$selectedLanguageViewPath = $browserLanguageViewPath;
		}
		else
		{
			$selectedLanguageViewPath = $defaultLanguageViewPath;
		}
		
		$viewOriginalContent = file_get_contents($selectedLanguageViewPath);
		$viewMountedContent = $this -> Mount($viewOriginalContent);
		
		echo $viewMountedContent;
		
		return;
	}
	private final function Mount(string $viewContent)
	{
		$mountedViewContent = $viewContent;
		$requestedResourceTags = array();
		
		preg_match_all('/<resource(.*)\/>/', $viewContent, $requestedResourceTags, PREG_SET_ORDER);
				
		for($i = 0; $i < count($requestedResourceTags); $i++)
		{
			$requestedResourceTypes = null;
			$requestedResourcePaths = null;
		
			preg_match('/type="(.*?)"/', $requestedResourceTags[$i][0], $requestedResourceType);
			preg_match('/path="(.*?)"/', $requestedResourceTags[$i][0], $requestedResourcePath);
			
			if(file_exists("application/views/{$requestedResourcePath[1]}"))
			{
				$resourceContent = file_get_contents("application/views/{$requestedResourcePath[1]}");
				$requestedResource = "<{$requestedResourceType[1]}>$resourceContent</{$requestedResourceType[1]}>";
				$mountedViewContent = str_replace($requestedResourceTags[$i][0], $requestedResource, $mountedViewContent);
			}
			else
			{
				$mountedViewContent = str_replace($requestedResourceTags[$i][0], "<script>console.error('Requested resource not found in path: {$requestedResourcePath[1]}')</script>", $mountedViewContent);
			}
		}
		
		$mountedViewContent = preg_replace('/\n\t/', '', $mountedViewContent);
		
		return $mountedViewContent;
	}	*/
}

?>