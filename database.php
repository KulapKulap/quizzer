<?php
    //catch error
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    //connect with db
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'quizzer';

    // Create a mysqli object
    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($mysqli->connect_error) {
    printf("Connect error: %s", $mysqli->connect_error);
    echo 'idi nah'; // I assume this is just for debugging purposes.
    exit();


    



}

?>

