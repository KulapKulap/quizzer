<?php include 'database.php'; ?>

<?php session_start(); ?>

<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

    //$_SESSION - global array
    if(!isset($_SESSION['score'])){
        $_SESSION['score']=0;
    }


    


    if($_POST){
        //echo 'sussess';
        //['number'] comes from name="number" from html; name="choice" - is our answers
        $number=$_POST['number'];

        $selected_choice=$_POST['choice'];
        $selected_choice_text="";

        print_r($selected_choice);
        
        //next question
        $next=$number+1;

        $is_correct=0;


        //get total questions:
        $query="SELECT * FROM `questions`";
        $results=$mysqli->query($query) or die($mysqli->error.__LINE__);
        $total=$results->num_rows;

        //get correct choice
        $query = "SELECT * FROM `choices` 
                WHERE question_number = $number AND is_correct = 1";

        $result=$mysqli->query($query) or die($mysqli->error.__LINE__);
        $row=$result->fetch_assoc();
        
        $correct_choice=$row['id'];
        $correct_choice_text=$row['text'];
        print_r($correct_choice_text);

        



        



        


        

        

        


        
//----------------------------------------------from question.php
    
    $login = $_COOKIE['user'];
    $user_id = $_COOKIE['user_id'];

    //]-------------
    $q_id=$_SESSION['q_id'];
    $q_text=$_SESSION['q_text'];

    //array of all choices
    $all_options=$_SESSION['all_options'];
    $options=$_SESSION['options'];


    //--------------------------- foreach

    foreach ($options as $option) {
        if ($option['id'] == $selected_choice) {
            $selected_choice_text=$option['text'];
            break;
        }
    }



  


    

//compare
if($correct_choice==$selected_choice){
    $_SESSION['score']++;
    $is_correct=1;
}




  

    $mysql = new mysqli('localhost', 'root', '', 'quizzer');
    $result = $mysql->query("INSERT INTO `students_answers`(`user_id`, `user`,`q_id`,`q_text`,`is_correct`, `selected_choice_text`,`correct_choice_text`) VALUES ('$user_id','$login','$q_id', '$q_text',$is_correct, '$selected_choice_text','$correct_choice_text')");



//-------------------



        

//----------------------------------------------------------------------end from question.php


//check if it was the last question
if($number==$total){

    //redirect
    header("Location:final.php");
    exit();  
}else{
    header("Location: question.php?n=".$next);
}


//----


        










    }
?>





