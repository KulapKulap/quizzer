<?php 

include 'database.php';
include 'process.php'; 
?>

<?php   




$score = $_SESSION['score']; 
$user_id = $_COOKIE['user_id'];
$user = $_COOKIE['user'];
$password = $_COOKIE['password'];



$query = "INSERT INTO `students_scores` (`user_id`, `user`, `score`)
         VALUES ('$user_id', '$user', '$score')";
$insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);

$mysqli->close();

?>





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
        </div>
    </header>

    <main>
        <div class="container">
            <p>You have completed the test!</p>
            <p>Final score: <?php echo $score; ?></p>
            <?php $_SESSION['score'] = 0; // Reset the score to NULL ?>
            <a href="question.php?n=1" class="start">Take Again!</a>
            <a href="exit.php" class="start">Logout</a>
            <a href="users.php" class="start">Go see tables</a>

            <?php
            $username = "root";

            if ($user === "teacher" && $password==="teacher") {
            ?>
            
            <a href="add.php" class="start">Add question</a>
            <?php
            }
            ?>

            <p><?php echo "user id: ".$user_id; ?></p>
            <p><?php echo "user: ".$user; ?></p>
            

        </div>

    </main>

    <footer>
        <div class="container">
            <p>Copyright &copy; </p>
        </div>
    </footer>
</body>
</html>
