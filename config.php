<?php
$servername = "localhost";
$username = "root";
$password = "";  // XAMPP में default password खाली होता है
$database = "picstar_test"; // Database का नाम

$conn = new mysqli($servername, $username, $password, $database);

// Error Handle करो
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
