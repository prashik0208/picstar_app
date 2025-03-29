<?php
$host = "localhost";  
$user = "root";      
$pass = "";         
$db = "video_site";   

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

if (isset($_GET["approve"])) {
    $id = $_GET["approve"];
    $sql = "UPDATE payments SET status='approved' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Payment Verified!'); window.location.href='admin_verify.php';</script>";
    }
}

$sql = "SELECT * FROM payments WHERE status='pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Payment Verification</title>
</head>
<body>
    <h2>Pending Payments</h2>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <p>User: <?= $row['username'] ?> | Plan: <?= $row['plan'] ?></p>
        <img src="<?= $row['screenshot'] ?>" width="200px"><br>
        <a href="?approve=<?= $row['id'] ?>">Approve Payment</a>
    <?php } ?>
</body>
</html>
