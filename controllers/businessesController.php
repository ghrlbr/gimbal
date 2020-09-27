<?php

class BusinessesController extends Controller implements ControllerInterface
{
    public function search(array $data){

        $filters = [];

        $latitude       = isset($data['params']['latitude'])    ? $data['params']['latitude']   : null;
        $longitude      = isset($data['params']['longitude'])   ? $data['params']['longitude']  : null;
        $categories     = isset($data['params']['categories'])  ? $data['params']['categories'] : null;

        // Próximo passo é desenvolver os validadores daqui

        if(!is_null($latitude))         $filters['latitude'] = $latitude;
        if(!is_null($longitude))        $filters['longitude'] = $longitude;
        if(!is_null($categories))       $filters['categories'] = $categories;

        $businesses_handler = new BusinessesHandler();
        return $businesses_handler -> search($filters);
    }
}

?>