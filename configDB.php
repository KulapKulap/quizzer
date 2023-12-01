<?php
    //connect database via PDO. if we have a lot of files!
    //example from mamp
    $dsn='mysql:host=localhost:8889;dbname=to-do';
    $pdo=new PDO($dsn, 'root', 'root');
?>