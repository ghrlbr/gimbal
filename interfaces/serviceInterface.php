<?php

interface ServiceInterface
{
    public function get(int $id) : stdClass;
    public function edit(int $id, array $data) : bool;
    public function add(array $data) : int;
    public function delete(int $id) : bool;
    public function search(array $data) : array;
    public function exists(array $data) : bool;
    public function query(string $sql) : array;
}

?>