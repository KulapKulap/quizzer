<?php include 'database.php'; ?>
<?php session_start(); ?>
<?php 



    //set question  number (?n=1) here $number=1
    $number=(int) $_GET['n'];


    

    

    //get total questions:
    $query="SELECT * FROM `questions`";
    $results=$mysqli->query($query) or die($mysqli->error.__LINE__);
    $total=$results->num_rows;

    //get question
    $query="SELECT * FROM `questions`
            WHERE question_number=$number";
    
    $result=$mysqli->query($query) or die($mysqli->error.__LINE__);
    $question=$result->fetch_assoc();
    




    //get choices for one question
    $query="SELECT * FROM `choices`
            WHERE question_number=$number";
    
    $choices=$mysqli->query($query) or die($mysqli->error.__LINE__);



    //------get choices for all questions

    //get choices
    $query="SELECT * FROM `choices`";
    
    $all_choices=$mysqli->query($query) or die($mysqli->error.__LINE__);
    $all_options = $all_choices->fetch_all(MYSQLI_ASSOC);

    //------
    


    //----------------------------------------------
    $login = $_COOKIE['user'];
    $user_id = $_COOKIE['user_id'];
    $q_id=$question['question_number'];
    $q_text=$question['text'];

    //]------------- turn into session
    $_SESSION['q_id'] = $question['question_number'];
    $_SESSION['q_text'] = $question['text'];
    $_SESSION['total'] = $total;



    



    

    

    


    

//-------










//--------


  

    //$mysql = new mysqli('localhost', 'root', '', 'quizzer');
    //$result = $mysql->query("INSERT INTO `students_answers`(`user_id`, `user`,`q_id`,`q_text`, //`is_correct`) VALUES ('$user_id','$login','$q_id', '$q_text',$is_correct)");










    
    

    



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
            <?php
                $username = $_COOKIE['user'];

                echo "<p>hello, $username</p>";
                echo "Score: " . $_SESSION['score'];
                

                echo '<a href="/quizzer/start.php" class="start">Start again</a>';
                echo '<a href="/quizzer/exit.php" class="start">Logout</a>';
            ?>
        </div>

    </header>

    <main>
            
        <div class="container">
            <p><?php echo $question['question_number'];?></p>
            
            
            
            
            
            
            
            <div class="current">Question <?php echo $question['question_number']; ?> of <?php echo $total; ?></div>
            <!-- $question['text'], well ['text'] comes from database of questions-->
            <p class="question"><?php echo $question['text']?></p>


            <form method="post" action="process.php">
                <ul class="choices">

                    <!-- means while we have something in the row. fetch_assoc() - makes array-->
                    <!-- shuffle answers-->
                    <?php
                        $options = $choices->fetch_all(MYSQLI_ASSOC);
                        shuffle($options);
                    ?>
                    <?php foreach ($options as $row) { ?>
                    <li><input name="choice" type="radio" value="<?php echo $row['id']; ?>"> <?php echo $row['text']; ?></li>

                    
                    
                    <?php } ?>

                </ul>
                <input type="submit" value="Submit">
                <input type="hidden" name="number" value="<?php echo $number?>">
                <input type="hidden" name="options" value="<?php $_SESSION['all_options'] = $all_options;?>">
                <input type="hidden" name="options" value="<?php $_SESSION['options'] = $options;?>">
            </form>
        </div>

    </main>

    <footer>
        <div class="container">
        <p>Copyright &copy;</p>
        </div>

</footer>
</body>
</html>