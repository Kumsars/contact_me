<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'db_config.php';

    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $data = json_decode(file_get_contents("index.html"));
?>
