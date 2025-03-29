<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "video_site";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Getting the selected plan
if (isset($_GET["plan"])) {
    $plan = $_GET["plan"];
    $username = "JohnDoe";  // (याद रखना: Login System जोड़ने के बाद $username = $_SESSION['username']; से यूजर का नाम आएगा)

    $sql = "UPDATE users SET subscription='$plan' WHERE username='$username'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>
            alert('Subscription to $plan Plan Successful!');
            window.location.href='profile.html';
        </script>";
    } else {
        echo "<script>alert('Subscription Failed!');</script>";
    }
}
?>
