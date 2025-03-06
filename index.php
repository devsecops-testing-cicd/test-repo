<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "comments_db";

/*
CREATE DATABASE comments_db;

USE comments_db;

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    comment TEXT NOT NULL
);
*/

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle comment submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Intentionally vulnerable to SQL Injection
    $comment = $_POST['comment'];
    $sql = "INSERT INTO comments (comment) VALUES ('$comment')";
    $conn->query($sql);
}

// Fetch comments
$result = $conn->query("SELECT * FROM comments");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
</head>
<body>
    <h1>Comments</h1>
    <form method="POST" action="">
        <textarea name="comment" required></textarea>
        <button type="submit">Submit</button>
    </form>

    <h2>Visitor Comments:</h2>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Intentionally vulnerable to XSS
                echo "<li>" . $row['comment'] . "</li>";
            }
        } else {
            echo "<li>No comments yet.</li>";
        }
        ?>
    </ul>
</body>
</html>

<?php
// Close connection
$conn->close();
?>
