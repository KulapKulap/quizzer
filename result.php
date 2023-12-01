<?php
    $login=filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $gender=filter_var(trim($_POST['gender']),
    FILTER_SANITIZE_STRING);
    $score=filter_var(trim($_SESSION['score']),
    FILTER_SANITIZE_STRING);


    $mysql=new mysqli('localhost', 'root', '', 'quizzer');
    $mysql->query("INSERT INTO `users_answers` (`login`,`gender`, `score`)
    VALUES('$login', '$gender', '$score')");
    $mysql->close();

    
    //readdressing to the main page
    header('Location: /quizzer/start.php');

    
?>