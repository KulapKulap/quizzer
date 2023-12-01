<?php 

include 'database.php';
?>

<?php
    $login=filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);

    $name=filter_var(trim($_POST['name']),
    FILTER_SANITIZE_STRING);

    $pass=filter_var(trim($_POST['pass']),
    FILTER_SANITIZE_STRING);


    //if tooo short or toooo long
    if(mb_strlen($login)<5 || mb_strlen($login)>90){
        echo "unappropriate length login";
        exit();
    }else if(mb_strlen($name)<3 || mb_strlen($name)>50){
        echo "unappropriate length name";
        exit();
    }
    

    //adding hash and salt
    $pass=md5($pass."74567458htghrjgr");

    $mysql=new mysqli('localhost', 'root', '', 'quizzer');
    $mysql->query("INSERT INTO `users` (`login`, `pass`, `name`)
    VALUES('$login', '$pass', '$name')");
    $mysql->close();



    
    //readdressing to the main page
    header('Location: /quizzer/');





?>