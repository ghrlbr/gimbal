<?php

include_once CORE_DIRECTORY . 'database.php';

class Model extends ActiveRecord\Model
{
    public static $DELETED = 'Y';
    public static $NOT_DELETED = 'N';
}

?>