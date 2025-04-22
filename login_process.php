<?php
session_start();
include 'db.php';

// Enable error reporting (for development only)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from POST request
    $email = $_POST['email']; // assuming "username" input field stores email
    $password = $_POST['password'];

    // Query to fetch user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // ✅ Verify hashed password
        if (password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password doesn't match
            echo "<script>alert('Invalid password'); window.location.href='login.php';</script>";
        }
    } else {
        // No such user
        echo "<script>alert('No user found with that email'); window.location.href='login.php';</script>";
    }
}
?>
