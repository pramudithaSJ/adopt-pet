<?php
include 'db.php';
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petName = $_POST['petName'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $isPublished = isset($_POST['isPublished']) ? 1 : 0;

    // Get owner ID from session
    $ownerID = $_SESSION['user_id'] ?? null;

    if (!$ownerID) {
        echo "User not logged in.";
        exit();
    }

    // Upload image
    $originalName = $_FILES['petImage']['name'];
    $imageName = str_replace(' ', '_', $originalName);
    $tmpName = $_FILES['petImage']['tmp_name'];
    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . basename($imageName);

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($tmpName, $uploadPath)) {
        $sql = "INSERT INTO posts (petName, type, description, image, ownerID, isPublished)
                VALUES ('$petName', '$type', '$description', '$imageName', '$ownerID', '$isPublished')";

        if ($conn->query($sql)) {
            echo "<script>alert('Post uploaded successfully!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Image upload failed.";
    }
}
?>
