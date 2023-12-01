<?php include 'database.php'; ?>

<?php 
    //get total number of questions dynamically
    //SQL:
    $query=$query="SELECT * FROM `questions`";
    $results=$mysqli->query($query) or die($mysqli->error.__LINE__);
    $total=$results->num_rows;
    $user="";
    $password=$_COOKIE['password'];

?>

<?php include 'database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP quizzer</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    



    <header>
        <div class="container">
            <h1>CSS quizzer</h1>
            <p>hello, <?= $_COOKIE['user'] ;
                $user=$_COOKIE['user'];
            ?></p>

        </div>

    

    <!-- Main Content -->
    <main>
        <div class="container">
            <h2>basic</h2>
            <ul>
                <li>Number of questions:<?php echo $total?></li>
                <li>Type of quiz: multiple choice</li>
                <li>Estimated time: <?php echo $total * 0.5 ?> mins</li>
            </ul>
            <a href="question.php?n=1" class="start">Start</a>
            <?php
            if ($user === "teacher" && $password==="teacher") {
            ?>
            <a href="users.php" class="start">Go see tables</a>
            <a href="add.php" class="start">Add question</a>
            
            <?php
            }
            
            ?>
            <a href="/quizzer/exit.php" class="start">Logout</a>
            
            
        </div>
        <hr>


       
    </main>


    <footer>
        <div class="container">
        <p>Copyright &copy;</p>
        </div>

</footer>
</body>
</html>