<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'db_config.php';
    include 'config.php';

    $data = json_decode(file_get_contents("php://input"));
    $respondCB = $data->torespond == "" ? 0
     : 1 ;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$data->token])) {

        // Build POST request:
        $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = SECRET_KEY;
        $recaptcha_response = $_POST[$data->token];
    
        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
        $recaptcha = json_decode($recaptcha);
    
        // Take action based on the score returned:
        if ($recaptcha->score >= 0.5) {
            echo "SUCCESS";
        } else {
            // Not verified - show form error
        }

    }   

     $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

     if (mysqli_connect_errno()) {
         echo mysqli_connect_error();
         exit();
     }
 
     if ($mysqli->connect_errno) {
         echo "Connect failed: %s\n".$mysqli->connect_error;
         exit();
     }
     if (!$mysqli -> query("INSERT INTO contacts (email, comment, torespond) VALUES ('$data->email', '$data->comment', '$respondCB')")) {
        echo "Error description: ". $mysqli -> error;
      }
    /* close connection */
    $mysqli->close();
?>
