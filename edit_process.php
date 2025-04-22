<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: dashboard.php");
    exit();
}

// Get form data
$postID = $_POST['postID'] ?? null;
$petName = trim($_POST['petName'] ?? '');
$type = trim($_POST['type'] ?? '');
$description = trim($_POST['description'] ?? '');
$isPublished = isset($_POST['isPublished']) ? 1 : 0;
$ownerID = $_SESSION['user_id'];

// Validate input
if (empty($postID) || empty($petName) || empty($type) || empty($description)) {
    $_SESSION['error_message'] = "All fields are required.";
    header("Location: editPet.php?postID=$postID");
    exit();
}

// Check post ownership
$check_sql = "SELECT * FROM posts WHERE postID = ? AND ownerID = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $postID, $ownerID);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows != 1) {
    $_SESSION['error_message'] = "Post not found or you don't have permission to edit it.";
    header("Location: dashboard.php");
    exit();
}

$post = $result->fetch_assoc();
$current_image = $post['image'];

// Check if new image was uploaded
$new_image_name = $current_image; // Default to current image
if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] == 0) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['petImage']['name'];
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    // Validate file extension
    if (!in_array($file_extension, $allowed_extensions)) {
        $_SESSION['error_message'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        header("Location: editPet.php?postID=$postID");
        exit();
    }
    
    // Generate unique filename
    $new_image_name = uniqid('pet_') . '.' . $file_extension;
    $upload_path = 'uploads/' . $new_image_name;
    
    // Move uploaded file
    if (move_uploaded_file($_FILES['petImage']['tmp_name'], $upload_path)) {
        // Delete old image if different from default
        if ($current_image != 'default_pet.jpg' && file_exists('uploads/' . $current_image)) {
            unlink('uploads/' . $current_image);
        }
    } else {
        $_SESSION['error_message'] = "Failed to upload image.";
        header("Location: editPet.php?postID=$postID");
        exit();
    }
}

// Update post in database
$update_sql = "UPDATE posts SET petName = ?, type = ?, description = ?, image = ?, isPublished = ? WHERE postID = ? AND ownerID = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("ssssiis", $petName, $type, $description, $new_image_name, $isPublished, $postID, $ownerID);

if ($update_stmt->execute()) {
    $_SESSION['success_message'] = "Pet post updated successfully!";
    header("Location: dashboard.php");
} else {
    $_SESSION['error_message'] = "Error updating post: " . $conn->error;
    header("Location: editPet.php?postID=$postID");
}

// Close statements
$check_stmt->close();
$update_stmt->close();
?>