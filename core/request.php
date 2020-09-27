<?php

class Request
{
    public function getBody(){
        $data = [];
        $input = file_get_contents("php://input");
        parse_str($input, $data);
        return array_merge($data, $_POST);
    }
    public function getParams(){
        return $_GET;
    }
    public function getHeaders(){
        return getallheaders();
    }

    public function query(){
        $params = [];
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query, $params);
        return $params;
    }
    public function method(){
        return $_SERVER['REQUEST_METHOD'];
    }
}

?>