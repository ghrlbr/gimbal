<?php

class BusinessesHandler extends Handler implements HandlerInterface
{
    public function search(array $filters) : array {
        $businesses_service = new BusinessesService();
        return $businesses_service -> search($filters);
    }
}

?>