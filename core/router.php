<?php

class Router
{
    public static function onRequest(){
        $request = new Request();

        $method = $request -> method();
        $query = $request -> query();

        $body = $request -> getBody();
        $params = $request -> getParams();
        $headers = $request -> getHeaders();

        $data = [
            'body'      => $body,
            'params'    => $params,
            'headers'   => $headers
        ];

        $url = $query['url'];
        $paths = explode('/', $url);
        $paths = array_filter($paths);

        if(!count($paths))
            throw new Exception('E130620200831');

        $controller = $paths[0];
        $action = $method;

        if(in_array($controller, ALLOWED_DIRECTORIES_TO_ACCESS_DIRECTLY)){
            
            $path = OPERATING_SYSTEM_DIRECTORY . $url;
            $name = pathinfo($path, PATHINFO_FILENAME);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = $name . '.' . $extension;

            header('Content-Length: ' . filesize($path));
            header('Content-Disposition: attachment; filename="' . $filename . '";');
    
            ob_clean();
            flush();
            readfile($path);

            exit;
        }

        if(isset($paths[1]))
            $action = $paths[1];

        $controllerFile = $controller . 'controller.php';
        $controllerFilePath = CONTROLLERS_DIRECTORY . $controllerFile;

        if(!file_exists($controllerFilePath))
            throw new Exception('E130620200832');

        include_once $controllerFilePath;

        $controllerClassName = $controller . 'controller';
        $controllerClassInstance = new $controllerClassName($data);
        $controllerMethodName = $action;

        if(!method_exists($controllerClassInstance, $controllerMethodName))
            throw new Exception('E130620200833');

        return $controllerClassInstance -> $controllerMethodName($data);
    }
}

?>