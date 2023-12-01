<?php
    $login=filter_var(trim($_POST['login']),
    FILTER_SANITIZE_STRING);
    $password=filter_var(trim($_POST['password']),
    FILTER_SANITIZE_STRING);



    $mysql=new mysqli('localhost', 'root', '', 'quizzer');
    $result=$mysql->query("SELECT * FROM `users` WHERE `login`='$login' AND `password`='$password'");
    
    //fetch_assoc() - from string make an array! count - poshitat
    $user=$result->fetch_assoc();
    if(count($user)==0){
        //on page auth.php
        echo "user not found";
        exit();
    }

    //for authorization we use cookie. 3600 - one hour. 'user' - is name of cookie,  "/" - everywhere on website, all pages!!
    setcookie('user', $user['name'], time()+3600, "/");
    setcookie('user_id', $user['user_id'], time() + 3600, "/");
    setcookie('password', $user['password'], time() + 3600, "/");
    

    $mysql->close();

    //readdressing to the main page
    header('Location: /quizzer/');
?>
