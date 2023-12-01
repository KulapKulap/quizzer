<?php include 'database.php'; ?>
<?php 

    //['submit'] comes from the name of html element!!!
    if(isset($_POST['submit'])){
        $question_number=$_POST['question_number'];
        $question_text=$_POST['question_text'];
        $correct_choice=$_POST['correct_choice'];

        //choices are array.but can do without array
        $choices=array();
        $choices[1]=$_POST['choice1'];
        $choices[2]=$_POST['choice2'];
        $choices[3]=$_POST['choice3'];
        $choices[4]=$_POST['choice4'];

        $query="INSERT INTO `questions` (`question_number`, `text`)
                VALUES('$question_number','$question_text')";
        //($query) - is was just created from above
        $insert_row=$mysqli->query($query) or die($mysqli->error.__LINE__);


        //add choices:
        if($insert_row){
            foreach($choices as $choice=>$value){
                if($value!=''){
                    if($correct_choice==$choice){
                        $is_correct=1;
                    }else{
                        $is_correct=0;
                    }
                    
                    //insert choices
                    $query="INSERT INTO `choices` (`question_number`, `is_correct`,`text`) VALUES ('$question_number','$is_correct','$value')";

                    //run query
                    $insert_row=$mysqli->query($query) or die($mysqli->error.__LINE__);

                    //validate insert
                    if($insert_row){
                        continue;
                    }else{
                        die('Error:('.$mysqli->errno . ') '. $mysqli->error);
                    }
                    
                }
            }
            $msg='Question has been added';
        }

    }
    
    //for question  number authomatically appears
    $query="SELECT * FROM `questions`";
    $questions=$mysqli->query($query) or die($mysqli->error.__LINE__);
    $total=$questions->num_rows;
    $next=$total+1;
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
            <h2>Add a question</h2>
            <?php
                if(isset($msg)){
                    echo '<p>'.$msg.'</p>';
                }
            ?>
            <form method="post" action="add.php">
                <p>
                    <label>Question number:</label>

                    <!--question number authomatically appears-->
                    <input type="number" value="<?php echo $next;?>" name="question_number">
                </p>
                <p>
                    <label>Question text</label>
                    <input type="text" name="question_text">
                </p>
                <p>
                    <label>Choice 1</label>
                    <input type="text" name="choice1">
                </p>
                <p>
                    <label>Choice 2</label>
                    <input type="text" name="choice2">
                </p>
                <p>
                    <label>Choice 3</label>
                    <input type="text" name="choice3">
                </p>
                <p>
                    <label>Choice 4</label>
                    <input type="text" name="choice4">
                </p>
                <p>
                    <label>Correct Choice</label>
                    <input type="number" name="correct_choice">
                </p>
                <p>
                    <input type="submit" name="submit" value="Submit">
                </p>
                
            </form>
        </div>

    </main>

    <footer>
        <div class="container">
        <p>Copyright &copy; Jin Hua</p>
        </div>

</footer>
</body>
</html>