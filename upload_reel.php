<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $song = $_POST["song"];
    $filter = $_POST["filter"];
    $video = $_FILES["video"];

    // Video Length Check (Max 2 Min)
    $maxDuration = 120; // 2 Min (120 sec)
    $ffmpegPath = "C:/ffmpeg/bin/ffprobe"; // FFMPEG ka path (Windows)
    $videoPath = $video["tmp_name"];
    $cmd = "$ffmpegPath -i $videoPath -show_entries format=duration -v quiet -of csv='p=0'";
    $duration = shell_exec($cmd);

    if ($duration > $maxDuration) {
        die("❌ Video must be 2 minutes or less!");
    }

    // File Upload
    $targetDir = "uploads/";
    $videoName = time() . "_" . basename($video["name"]);
    $targetFilePath = $targetDir . $videoName;

    if (move_uploaded_file($video["tmp_name"], $targetFilePath)) {
        $sql = "INSERT INTO reels (title, description, video, song, filter) VALUES ('$title', '$description', '$videoName', '$song', '$filter')";
        if ($conn->query($sql) === TRUE) {
            echo "✅ Reel Uploaded Successfully!";
        } else {
            echo "❌ Error: " . $conn->error;
        }
    } else {
        echo "❌ File Upload Failed!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Reel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Upload a Reel</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required><br>
        <textarea name="description" placeholder="Description"></textarea><br>
        <input type="text" name="song" placeholder="Song Name"><br>
        <input type="text" name="filter" placeholder="Filter Name"><br>
        <input type="file" name="video" accept="video/*" required><br>
        <button type="submit">Upload</button>
    </form>
</body>
</html>
