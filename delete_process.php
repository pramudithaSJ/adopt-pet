<?php
include 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if postID is provided
if (!isset($_GET['postID']) || empty($_GET['postID'])) {
    $_SESSION['message'] = "No post selected for deletion.";
    header("Location: dashboard.php");
    exit();
}

$postID = $_GET['postID'];
$ownerID = $_SESSION['user_id'];

// Security: Use prepared statement to prevent SQL injection
// First, fetch the post to check ownership and get image filename
$check_sql = "SELECT * FROM posts WHERE postID = ? AND ownerID = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $postID, $ownerID);
$check_stmt->execute();
$result = $check_stmt->get_result();

// If post doesn't exist or doesn't belong to user
if ($result->num_rows != 1) {
    $_SESSION['message'] = "Post not found or you don't have permission to delete it.";
    header("Location: dashboard.php");
    exit();
}

$post = $result->fetch_assoc();
$image_path = "uploads/" . $post['image'];

// Now delete the post from database
$delete_sql = "DELETE FROM posts WHERE postID = ? AND ownerID = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("ii", $postID, $ownerID);

if ($delete_stmt->execute()) {
    // After successful database deletion, attempt to delete the image file
    if (file_exists($image_path)) {
        unlink($image_path); // Delete the image file
    }
    
    $_SESSION['success_message'] = "Pet post successfully deleted!";
    
    
} else {
    $_SESSION['error_message'] = "Error deleting post: " . $conn->error;
}

// Close statements
$check_stmt->close();
$delete_stmt->close();

// Redirect back to dashboard
header("Location: dashboard.php");
exit();
?>