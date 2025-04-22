<?php
// Start session management
session_start();

// Include database connection file
require_once 'db.php';

// Define a function to display error and redirect back
function showError($message) {
    echo "<script>
            alert('" . $message . "');
            window.history.back();
          </script>";
    exit();
}

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get form data and sanitize inputs
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contact = isset($_POST['contact']) ? trim($_POST['contact']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    
    // 2. Validate all fields are filled
    if (empty($name) || empty($email) || empty($contact) || empty($password) || empty($confirm_password)) {
        showError('All fields are required');
    }
    
    // 3. Validate password match
    if ($password !== $confirm_password) {
        showError('Passwords do not match');
    }
    
    // 4. Check if email already exists (using prepared statement)
    $check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $result = $check_email->get_result();
    
    if ($result->num_rows > 0) {
        showError('Email already registered');
    }
    
    // 5. Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // 6. Insert user data into database using prepared statement
    $insert_user = $conn->prepare("INSERT INTO users (name, email, contact, password) VALUES (?, ?, ?, ?)");
    $insert_user->bind_param("ssss", $name, $email, $contact, $hashed_password);
    
    // 7. Execute the query and handle the result
    if ($insert_user->execute()) {
        // Success - redirect to login page
        echo "<script>
                alert('Registration successful! Please login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        // Database error
        showError('Registration failed: ' . $conn->error);
    }
    
    // Close prepared statements
    $check_email->close();
    $insert_user->close();
    
} else {
    // If someone tries to access this page directly without POST data
    header("Location: signup.html");
    exit();
}
?>