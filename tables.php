<?php
// tables.php

include 'database.php';
session_start();
$total=$_SESSION['total'];
$total_name="total";
$current_score_name="current";





if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch specific user information based on the user_id
    $query = "SELECT * FROM `users` WHERE `user_id` = $user_id";
    $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Display user information or perform actions based on $user data
        echo "<h1>User Details</h1>";
        echo '<a href="users.php" class="start">Go see tables</a><br>';
        echo '<a href="start.php" class="start">Restart Quiz</a><br>';
        echo '<a href="/quizzer/exit.php" class="start">Logout</a><br>';
        echo '<a href="/quizzer/users.php" class="start"><-- Back to Users</a>';
        
            
        echo "<p>User ID: " . $user['user_id'] . "</p>";
        echo "<p>Login: " . $user['login'] . "</p>";
        // Add more details as needed
    } else {
        echo "User not found";
    }
} else {
    echo "No user ID provided";
}


//--------render students_answers

$result = $mysqli->query("SELECT * FROM `students_answers` WHERE `user_id` = $user_id ORDER BY `time` ASC");
if ($result) {
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Data from 'students_answers' Table</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <style>
        #myChart, #scatterChart {
  width: 800px !important;  
  height: 600px !important;
}
    </style>
    <body>

    <h2>Data from 'students_answers' Table</h2>

    <table border="1">
        <thead>
            <tr>
                <th>iser id</th>
                <th>user</th>
                <th>q id</th>
                <th>q text</th>
                <th>is correct</th>
                <th>selected choice text</th>
                <th>correct choice text</th>
                <th>time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display each row in the table
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['q_id']; ?></td>
                    <td><?php echo $row['q_text']; ?></td>
                    <td><?php echo $row['is_correct']; ?></td>
                    <td><?php echo $row['selected_choice_text']; ?></td>
                    <td><?php echo $row['correct_choice_text']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    

    <?php
} else {
    // Handle errors if the query fails
    echo "Error: " . $mysql->error;
}


//--------render students_scores

$result = $mysqli->query("SELECT * FROM `students_scores` WHERE `user_id` = $user_id");
if ($result) {
    ?>

    
    <h2>Data from 'students_scores' Table</h2>

    <table border="1">
        <thead>
            <tr>
                <th>id</th>
                <th>user id</th>
                <th>user</th>
                <th>score</th>
                <th>time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display each row in the table
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['user']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                </tr>
                <?php
                
            }
      
            ?>
        </tbody>
    </table>


    
    

    

    <?php
} else {
    // Handle errors if the query fails
    echo "Error: " . $mysql->error;
}

//--------------------
$is_correct=[];
$result = $mysqli->query("SELECT * FROM `students_scores` WHERE `user_id` = $user_id AND `is_correct`=1");
if ($result) {
    
            // Loop through the results and display each row in the table
            while ($row = $result->fetch_assoc()) {
                echo $row['is_correct'];
                $is_correct=$row['is_correct'];
                 
                
            }
            echo "-------------------------";
            print_r($is_correct);
      
            
}


?>


<?php
// Fetch scores from the database
$scores = [];
$time=[];
$result = $mysqli->query("SELECT * FROM `students_scores` WHERE `user_id` = $user_id");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $scores[] = $row['score'];
        $time[] = $row['time'];
    }
}
$numScores = count($scores);
$lastScore = end($scores);




if (!empty($scores)) {
    $lastScore = end($scores);
    
}







// Create an array with elements from 1 to $numScores
$scoresArray = range(1, $numScores);
for ($i = 0; $i < $numScores; $i++) {
    $combinedArray[] = [$scoresArray[$i], $time[$i]];
}

print_r($scores);

?>


<button id="showChartButton">Show Analytics</button>
<canvas id="myChart" style="display: none;"></canvas>







<script>
        document.getElementById('showChartButton').addEventListener('click', function() {
            var canvas = document.getElementById('myChart');
            var ctx = canvas.getContext('2d');
        
        // Remove the existing chart if it exists
        if (window.myChart instanceof Chart) {
            window.myChart.destroy();
        }
        
        // Fetch scores and labels data from PHP or an API endpoint
        var scoresData = <?php echo json_encode($scores); ?>;
        var labelsData = <?php echo json_encode($combinedArray); ?>;
        
        // Create the new chart
        window.myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Correct Answers per Question',
                    data: scoresData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(0,0,0)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'rate'
                        }, 
                        ticks: {
                            stepSize: 1, // Set the step size to 1 for whole numbers
                            precision: 0,// Set precision to 0 to display whole numbers
                                
            }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'scores'
                        }
                    }
                }
            }
        });
        
        // Show the chart after creating it
        canvas.style.display = 'block';

        

        
    });

</script>

<?php

    if ($scores[0] > $scores[$lastScore]) {
        echo "Alas. Your result decreased 😞";
    }else if($scores[0] < $scores[$lastScore]){
        echo "Congrats! Your result increased 🎉";
        
    }else{
        echo "You barely make any progress";
    }

?>


<?php
$q_text = []; // Initialize an array to store all question texts

$result = $mysqli->query("SELECT * FROM `questions`");
if ($result) {
    ?>

    <h2>Data from 'questions' Table</h2>

    <table border="1">
        <thead>
            <tr>
                <th>q number</th>
                <th>text</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the results and display each row in the table
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['question_number']; ?></td>
                    <td><?php echo $row['text']; ?></td>
                </tr>
                <?php
                // Store each question's text in the $q_text array
                $q_text[] = $row['text'];
            }
            ?>
        </tbody>
    </table>

    <?php
} else {
    // Handle errors if the query fails
    echo "Error: " . $mysqli->error;
}
print_r($q_text); // Output the array containing all question texts
?>

//------







//--------- correctly answered questions in percent

<?php
$q_id = [];
$correct_q = [];

$result = $mysqli->query("SELECT * FROM `students_answers` WHERE `user_id` = $user_id AND `is_correct`=1");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $q_id[] = $row['q_id'];
        $correct_q[] = $row['is_correct']; 
    }
} else {
    // Handle errors if the query fails
    echo "Error: " . $mysqli->error;
}


$correct_q_count = count($correct_q);
$comboArray = []; // Initialize the combo array

for ($i = 0; $i < $correct_q_count; $i++) {
    $comboArray[] = [$q_id[$i], $correct_q[$i]]; // Corrected $correct_q
}

$valueCounts = [];

foreach ($comboArray as $item) {
    $key = $item[0];
    $value = $item[1];
    
    if (!isset($valueCounts[$key])) {
        $valueCounts[$key] = [];
    }
    
    if (!isset($valueCounts[$key][$value])) {
        $valueCounts[$key][$value] = 1;
    } else {
        $valueCounts[$key][$value]++;
    }
}


$valueCounts_sum = 0;
foreach ($valueCounts as $key => $value) {
    $valueCounts_sum += array_sum($value);
}

echo "Sum of all correct answers: $valueCounts_sum<br><br>";

$percentages = [];
foreach ($valueCounts as $key => $value) {
    $percentage = ($valueCounts_sum > 0) ? (array_sum($value) / $valueCounts_sum * 100) : 0;
    $percentages[$key] = number_format($percentage, 0); // Trim digits after the decimal point
}



$percentages = array_values($percentages);

// Display percentages for all questions
foreach ($percentages as $key => $percentage) {
    $questionNumber = $key; // Adjusting to display the correct question number
}


?>



//------
<h2>Correct Answers per Question</h2>

<canvas id="myPieChart" width="400" height="400"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Assuming $q_text is a PHP array containing labels for the pie chart
    var labels = <?php echo json_encode($q_text); ?>;
    var percentages = <?php echo json_encode($percentages); ?>;

    var ctx = document.getElementById('myPieChart').getContext('2d');
    
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pie Chart',
                data: percentages, // Data for the five slices
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    display: true // Hide the legend
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = labels[context.dataIndex];
                            return label + ': ' + context.parsed + '%';
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Percentages of correct answers for every question'
                }
            }
        }
    });
</script>


<?php
print_r($percentages) ;
print_r($q_text) ;
?>























</body>
</html>
