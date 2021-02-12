<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'db_config.php';
   // include 'config.php';

    $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    if (mysqli_connect_errno()) {
        echo mysqli_connect_error();
        exit();
    }

    if ($mysqli->connect_errno) {
        echo "Connect failed: %s\n".$mysqli->connect_error;
        exit();
    }

    $data = json_decode(file_get_contents("php://input"));
    $respondCB = $data->torespond == "" ? 0
     : 1 ;
    // if($_POST){
    //     function getCaptcha($SecretKey){
    //         $Response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".SECRET_KEY."&response={$SecretKey}");
    //         $Return = json_decode($Response);
    //         return $Return;
    //     }
    //     $Return = getCaptcha($_POST['g-recaptcha-response']);
    //     var_dump($Return);
    // }
     if (!$mysqli -> query("INSERT INTO contacts (email, comment, torespond) VALUES ('$data->email', '$data->comment', '$respondCB')")) {
        echo "Error description: ". $mysqli -> error;
      }
    /* close connection */
    $mysqli->close();
?>
