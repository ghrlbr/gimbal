<?php

class Autoloader
{
    public static function load($class){
        $paths = Autoloader::build_paths($class);

        for($i = 0; $i < count($paths); $i++){
            if(file_exists($paths[$i])){
                include_once $paths[$i];
            }
        }
    }
    public static function build_paths($file_name){
        return [
            OPERATING_SYSTEM_DIRECTORY . CONTROLLERS_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . FORMATTERS_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . HANDLERS_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . INTERFACES_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . MODELS_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . SERVICES_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . VALIDATORS_DIRECTORY . $file_name . '.php',
            OPERATING_SYSTEM_DIRECTORY . CORE_DIRECTORY . $file_name . '.php',
        ];
    }
}

spl_autoload_register(
    function($class){
        Autoloader::load($class);
    }
);

?>