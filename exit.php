<?php
    //kill cookie
    setcookie('user', $user['name'], time()-3600, "/");
    setcookie('user_id', $user['user_id'], time()-3600, "/");
    setcookie('password', $user['password'], time()-3600, "/");
    
    //readdressing to the main page
    header('Location: /quizzer/');
    
?>