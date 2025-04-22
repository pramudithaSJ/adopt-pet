<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 50px;
        }
        .option {
            width: 150px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .option:hover {
            transform: scale(1.1);
        }
        .option img {
            width: 80px;
            height: 80px;
        }
        .option p {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
 nav {
            display: flex;
            justify-content: center;
            background-color: #ff6600;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
        }
    </style>
</head>
<body>
 <nav>
        <a href="home.html">Home</a>
        <a href="displaypets.php">Available Pets</a>
        <a href="displayMyPets.php">My Posts</a>
        <a href="#">Adoption Process</a>
        <a href="#">Contact Us</a>
		<a href="login.php">Login</a>
    </nav>
   
    <h1>Welcome, <?php echo $_SESSION['user_name']; ?>! to Your Dashboard</h1>
    <p>Your email: <?php echo $_SESSION['email']; ?></p>
    <a href="logout.php" style="color:red; text-decoration:none;">Logout</a>
    <div class="container">
        <div class="option" onclick="location.href='displayMyPets.php'">
            <img src="Images/icon2.png" alt="View Posts">
            <p>View My Posts</p>
        </div>
        <div class="option" onclick="location.href='displayMyPets.php'">
            <img src="Images/icon3.png" alt="Edit Posts">
            <p>Edit My Posts</p>
        </div>
        <div class="option" onclick="location.href='uploadPet.php'">
            <img src="Images/icon4.png" alt="Add Posts">
            <p>Add New Post</p>
        </div>
        <div class="option" onclick="location.href='displayMyPets.php'">
            <img src="Images/icon5.png" alt="Delete Posts">
            <p>Delete Posts</p>
        </div>
    </div>
</body>
</html>
