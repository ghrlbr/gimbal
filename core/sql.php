<?php

class SQL
{
    public static function escape(string $value) : string {
        return addslashes($value);
    }
    public static function array_to_in(array $values) : string {
        for($i = 0; $i < count($values); $i++)
            $values[$i] = self::escape($values[$i]);
        $statement = implode("','", $values);
        if($statement) $statement = "'" . $statement . "'";
        return $statement;
    }
}

?>