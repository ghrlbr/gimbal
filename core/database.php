<?php

use ActiveRecord\Config;

$connections = [
    1 => 'mysql://' . DATABASE_USERNAME . ':' . DATABASE_PASSWORD . '@' . DATABASE_HOST . '/' . DATABASE_NAME . '?charset=' . DATABASE_CHARSET,
    2 => 'mysql://' . DATABASE_USERNAME . ':' . DATABASE_PASSWORD . '@' . DATABASE_HOST . '/' . DATABASE_NAME . '?charset=' . DATABASE_CHARSET,
    3 => 'mysql://' . DATABASE_USERNAME . ':' . DATABASE_PASSWORD . '@' . DATABASE_HOST . '/' . DATABASE_NAME . '?charset=' . DATABASE_CHARSET,
];

$config = Config::instance();
$config -> set_model_directory(MODELS_DIRECTORY);
$config -> set_connections($connections);
$config -> set_default_connection(ENVIRONMENT);

?>