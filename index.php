<?php 
   
    


?>


<!DOCTYPE html>
<html>
<body>

    <div>
    

    <?php
        //$_COOKIE - global array
        if($_COOKIE['user']==''):
    ?>
        <h1>Sign up here!</h1>
        <form action="reg.php" method="post">
            <input type="text" name="name" placeholder="name" required><br>
            <input type="text" name="login" placeholder="login" required><br>
            <input type="text" name="studentid" placeholder="studentid" required><br>
            <input type="password" name="password" placeholder="password" required><br>
            <input type="text" name="gender" placeholder="male/female" required><br>
            <input type="text" name="age" placeholder="age" required><br>
            <input type="submit" name="submit" value="Submit"><br>
        </form>
    </div>

    <div>
        <h1>Having account already? Log in please!</h1>
        <form action="auth.php" method="post">
            <input type="text" name="login" placeholder="login" required><br>
            <input type="password" name="password" placeholder="password" required><br>
            <input type="submit" name="submit" value="Submit"><br>
        </form>
        <?php else: ?>
            <p>hello, <?php echo $_COOKIE['user']?></p><br>
            <p>To log out, press <a href="/quizzer/exit.php">here</a>.</p><br>

            <p>To start quiz, press <a href="/quizzer/start.php">here</a>.</p>
            <p>Go to final page, press <a href="/quizzer/final.php">here</a>.</p>

            <!--debugging  <p>hello, <?php //var_dump($user_id); ?></p><br>-->
            
            <?php 
            //foreach ($user as $key => $value) {
            //    if ($key === 'user_id') {
            //        echo 'user_id: ' . $value;
            //        break; // Exit the loop after finding 'user_id'
            //    }
            //};?>



            
        <?php endif; ?>

        
    </div>

    

</body>
</html>