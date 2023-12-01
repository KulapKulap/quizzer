<!DOCTYPE html>
    <html>
    <head>
        <title>Data from 'students_answers' Table</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
        #ratingChart {
        width: 800px !important;  
        height: 600px !important;
}
    </style>
    </head>
    
    <body>
    
    <a href="/quizzer/start.php" class="start">Restart Quiz</a><br>
    <a href="/quizzer/exit.php" class="start">Logout</a><br>

<?php include 'database.php'; ?>
<?php session_start(); 
    $user="";
    
?>
<p>hello, <?= $_COOKIE['user'] ;
                $user=$_COOKIE['user'];
            ?></p>



<?php 
//!!! only for teacher
if ($_COOKIE['user'] === 'teacher') {
$query = "SELECT u.user_id, u.login, COALESCE(s.total_score, 0) AS total_score, COALESCE(s.attempts, 0) AS attempts
FROM users u
LEFT JOIN (
    SELECT user, SUM(score) AS total_score, COUNT(*) AS attempts
    FROM students_scores
    GROUP BY user
) s ON u.login = s.user
ORDER BY total_score DESC";

$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
$total = $results->num_rows;

// Rendering all users in a table
if ($total > 0) {
echo "<table border='1'>
  <thead>
      <tr>
          <th>User ID</th>
          <th>Login</th>
          <th>Total Score</th>
          <th>Attempts</th>
      </tr>
  </thead>
  <tbody>";

while ($row = $results->fetch_assoc()) {
// Output/render user information as table rows
echo "<tr>
      <td>" . $row['user_id'] . "</td>
      <td><a href='tables.php?user_id=" . $row['user_id'] . "'>" . $row['login'] . "</a></td>
      <td>" . $row['total_score'] . "</td>
      <td>" . $row['attempts'] . "</td>
      <!-- Add more columns as needed -->
    </tr>";

// Update the users table with the computed values for each user
$user_id = $row['user_id'];
$total_score = $row['total_score'];
$attempts = $row['attempts'];



$updateQuery = "UPDATE users SET total_score = $total_score, attempts = $attempts WHERE user_id = $user_id";

if ($mysqli->query($updateQuery)) {
  echo "Total score and attempts updated successfully for user with ID: $user_id<br>";
} else {
  echo "Error updating total score and attempts for user with ID: $user_id - " . $mysqli->error . "<br>";
}
}

echo "</tbody></table>";
} else {
echo "No users found";
}


?>





<?php 
    $users = [];
    $total_score = [];
    $attempts=[];
    $combinedArray = [];
    $result = $mysqli->query("SELECT * FROM `users`");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row['name'];
            $total_score[]=$row['total_score'];
            $attempts[]=$row['attempts'];
        }
    }

for ($i = 0; $i < count($total_score); $i++) {
    if ($attempts[$i] != 0) {
        $combinedArray[] = $total_score[$i] / $attempts[$i];
    } else {
        // Handle division by zero case, for example, assigning a default value
        $combinedArray[] = "N/A"; // or any other value to indicate division by zero
    }
}

print_r($combinedArray);
print_r($total_score);





?>

<button id="showChartButton">Show Ratings</button>
<canvas id="ratingChart" style="display: none;"></canvas>







<script>
        document.getElementById('showChartButton').addEventListener('click', function() {
            var canvas = document.getElementById('ratingChart');
            var ctx = canvas.getContext('2d');
        
        // Remove the existing chart if it exists
        if (window.myChart instanceof Chart) {
            window.myChart.destroy();
        }
        
        // Fetch scores and labels data from PHP or an API endpoint
        var scoresData = <?php echo json_encode($combinedArray); ?>;
        var labelsData = <?php echo json_encode($users); ?>;
        
        // Create the new chart
        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Students Ratings',
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
                            stepSize: 0.1, // Set the step size to 1 for whole numbers
                            precision: 1,// Set precision to 0 to display whole numbers
                                
            }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'students'
                        }
                    }
                }
            }
        });
        
        // Show the chart after creating it
        canvas.style.display = 'block';

        

        
    });

</script>








<?php }else{
    echo "u re : $user";

   // Assuming $user contains the user's login
$query = "SELECT u.user_id, u.login, COALESCE(s.total_score, 0) AS total_score, COALESCE(s.attempts, 0) AS attempts
FROM users u
LEFT JOIN (
    SELECT user, SUM(score) AS total_score, COUNT(*) AS attempts
    FROM students_scores
    GROUP BY user
) s ON u.login = s.user
WHERE u.login = '$user'
ORDER BY total_score DESC";


$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
$total = $results->num_rows;

// Rendering all users in a table
if ($total > 0) {
echo "<table border='1'>
  <thead>
      <tr>
          <th>User ID</th>
          <th>Login</th>
          <th>Total Score</th>
          <th>Attempts</th>
      </tr>
  </thead>
  <tbody>";

while ($row = $results->fetch_assoc()) {
// Output/render user information as table rows
echo "<tr>
      <td>" . $row['user_id'] . "</td>
      <td><a href='tables.php?user_id=" . $row['user_id'] . "'>" . $row['login'] . "</a></td>
      <td>" . $row['total_score'] . "</td>
      <td>" . $row['attempts'] . "</td>
      <!-- Add more columns as needed -->
    </tr>";

// Update the users table with the computed values for each user
$user_id = $row['user_id'];
$total_score = $row['total_score'];
$attempts = $row['attempts'];



$updateQuery = "UPDATE users SET total_score = $total_score, attempts = $attempts WHERE user_id = $user_id";

if ($mysqli->query($updateQuery)) {
  echo "Total score and attempts updated successfully for user with ID: $user_id<br>";
} else {
  echo "Error updating total score and attempts for user with ID: $user_id - " . $mysqli->error . "<br>";
}
}

echo "</tbody></table>";
} else {
echo "No users found";
}


    

}
?>

</body>
    </html>
