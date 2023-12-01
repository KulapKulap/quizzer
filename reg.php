<?php
$name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
$studentid = filter_var(trim($_POST['studentid']), FILTER_SANITIZE_STRING);
$password = $_POST['password']; // Avoid using FILTER_SANITIZE_STRING for password
$gender = filter_var(trim($_POST['gender']), FILTER_SANITIZE_STRING);
$age = filter_var(trim($_POST['age']), FILTER_SANITIZE_STRING);

// Establish a database connection
$mysql = new mysqli('localhost', 'root', '', 'quizzer');

// Check for connection errors
if ($mysql->connect_error) {
    die("Connection failed: " . $mysql->connect_error);
}

// Prepare the SQL query
$query = "INSERT INTO `users` (`name`, `login`, `studentid`, `password`, `gender`, `age`)
    VALUES('$name', '$login', '$studentid', '$password', '$gender', '$age')";

// Execute the query and handle errors
if ($mysql->query($query) === TRUE) {
    // Redirect to the main page upon successful insertion
    header('Location: /quizzer/');
    exit();
} else {
    // Display an error message if insertion fails
    echo "Error: " . $mysql->error;
}

$mysql->close(); // Close the database connection
?>
