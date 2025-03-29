<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_FILES["video"]) || $_FILES["video"]["error"] !== UPLOAD_ERR_OK) {
        die(json_encode(["status" => "error", "message" => "❌ वीडियो अपलोड नहीं हुआ!"]));
    }

    $video = $_FILES["video"];
    $targetFile = $uploadDir . time() . "_" . basename($video["name"]);

    if (move_uploaded_file($video["tmp_name"], $targetFile)) {
        file_put_contents("reels.json", json_encode(["video" => $targetFile]));
        echo json_encode(["status" => "success", "message" => "✅ रील अपलोड हो गई!", "videoUrl" => $targetFile]);
    } else {
        echo json_encode(["status" => "error", "message" => "❌ अपलोड फेल!"]);
    }
}
?>


