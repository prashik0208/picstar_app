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

if (isset($_POST["submit_payment"])) {
    $username = $_POST["username"];
    $plan = $_POST["plan"];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["payment_screenshot"]["name"]);
    
    if (move_uploaded_file($_FILES["payment_screenshot"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO payments (username, plan, screenshot, status) VALUES ('$username', '$plan', '$target_file', 'pending')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Payment Uploaded Successfully! Admin will verify and activate your plan.'); window.location.href='profile.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Error Uploading Payment Screenshot!');</script>";
    }
}
?>
