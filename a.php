$query = "SELECT u.user_id, u.login, COALESCE(s.total_score, 0) AS total_score, COALESCE(s.attempts, 0) AS attempts
FROM users u
LEFT JOIN (
    SELECT user, SUM(score) AS total_score, COUNT(*) AS attempts
    FROM students_scores
    GROUP BY user
) s ON u.login = s.user
WHERE u.login = $user 
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