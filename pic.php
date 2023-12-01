<?php 
include "database.php";

//get choices
$query = "SELECT * FROM `hui`";
$pics = $mysqli->query($query) or die($mysqli->error.__LINE__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Images</title>
</head>
<body>
    <main>
    <div class="container">
            <!-- Fetch images and display them -->
            <?php while ($row = $pics->fetch_assoc()) { ?>
                <img src="data:image/png;base64,<?php echo base64_encode($row['pic']); ?>">
            <?php } ?>
        </div>
    </main>
</body>
</html>
