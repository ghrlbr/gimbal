<?php

class BusinessesService extends Service implements ServiceInterface
{
    public $model_name = 'BusinessesModel';

    public function search(array $data) : array {

        $sql = "
            SELECT `" . $this -> model_name::$table_name . "`.*
            FROM `" . $this -> model_name::$table_name . "`
            WHERE
        ";

        $sql .= " `" . $this -> model_name::$table_name . "`.is_deleted = '" . $this -> model_name::$NOT_DELETED . "' ";
        if(isset($data['latitude']))    $sql .= " AND `" . $this -> model_name::$table_name . "`.latitude <= '" . SQL::escape($data['latitude']) . "' ";
        if(isset($data['longitude']))   $sql .= " AND `" . $this -> model_name::$table_name . "`.longitude <= '" . SQL::escape($data['longitude']) . "' ";
        if(isset($data['categories']))  $sql .= " AND `" . $this -> model_name::$table_name . "`.category_id IN(" . SQL::array_to_in($data['categories']) . ") ";
       
        die($sql);
        return $this -> query($sql);
    }
}

?>