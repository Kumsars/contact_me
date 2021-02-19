<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once 'db_config.php';
    include 'config.php';

    //Ieliekt $data mainīgajā sūtāmos datus
    $data = json_decode(file_get_contents("php://input")); 
   
    $respondCB = $data->torespond == "on" ? 1
     : 0 ;

   
   
    // Piešķir mainīgajiem vērtības
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = SECRET_KEY;
    $recaptcha_response = $data->token;

    // Veido POST requestu un saņem responsu
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);

    //echo $recaptcha; --- sagaidu json response
    $recaptcha = json_decode($recaptcha);   
    
    //echo $recaptcha; --- sagaidu json response
    // Pēc atgrieztā JSON pārbauda score
    if ($recaptcha->score >= 0.5) {
        //true
            //Veido konekciju ar datu bāzi
        $mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

        //Pārbauda konekciju
        if (mysqli_connect_errno()) {
            echo mysqli_connect_error();
            exit();
        }
    
        if ($mysqli->connect_errno) {
            echo "Connect failed: %s\n".$mysqli->connect_error;
            exit();
        }

        
        $validEmail = htmlspecialchars($data->email, ENT_QUOTES);
        $validComment = htmlspecialchars($data->comment, ENT_QUOTES);
        $validRespond = htmlspecialchars($respondCB, ENT_QUOTES);
        
       
        if (!filter_var($validEmail, FILTER_VALIDATE_EMAIL)) {
             echo http_response_code(422);
        }else{
              //Ja neizpildās INSERTs-> izvada error info

            if (!$mysqli -> query("INSERT INTO contacts (email, comment, torespond) VALUES ('$validEmail', '$validComment', '$validRespond')")) {
                echo "Error description: ". $mysqli -> error; 
            }
        }

      
        
        $mysqli->close();
    }

     

   
?>
