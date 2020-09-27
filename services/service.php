<?php

class Service
{
    public function add(array $data) : int {
        $model = new $this -> model_name();
        foreach($data as $key => $value)
            $model -> $key = $value;
        $model -> save();
        return $model -> id;
    }
    public function edit(int $id, array $data) : bool {
        $model = $this -> model_name::find('one', [
                'conditions' => [
                    'id' => $id,
                    'is_deleted' => $this -> model_name::$NOT_DELETED,
                ]
            ]
        );
        foreach($data as $key => $value)
            $model -> $key = $value;
        return $model -> save();
    }
    public function get(int $id) : stdClass {
        return (object) $this -> model_name::find('one', [
                'conditions' => [
                    'id' => $id,
                ]
            ]
        ) -> to_array();
    }
    public function delete(int $id) : bool {
        $model = $this -> model_name::find('one', [
                'conditions' => [
                    'id' => $id,
                ]
            ]
        );
        $model -> $is_deleted = $this -> model_name::$DELETED;
        return $model -> save();
    }
    public function exists(array $data) : bool {
        $data['is_deleted'] = $this -> model_name::$NOT_DELETED;
        $model = $this -> model_name::find('one', [
                'select' => 'count(id) as count',
                'conditions' => $data
            ]
        );
        if($model -> count <= 0) return false;
        return true;
    }
    public function search(array $data) : array {
        return [];
    }
    public function query(string $sql) : array {
        $lines = $this -> model_name::find_by_sql($sql);
        for($i = 0; $i < count($lines); $i++)
            $lines[$i] = (object) $lines[$i] -> to_array();
        return $lines;
    }
}

?>