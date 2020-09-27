<?php

class Handler
{
    public $entity_id = null;

    public function __construct(int $entity_id = null){
        if(!is_null($entity_id)){
            $this -> entity_id = $entity_id;
        }
    }
}

?>