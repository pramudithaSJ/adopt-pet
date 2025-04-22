<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$postID = $_GET['postID'] ?? null;

// Security: Use prepared statement to prevent SQL injection
$sql = "SELECT * FROM posts WHERE postID = ? AND ownerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $postID, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows != 1) {
    echo "<script>alert('Post not found or you don\'t have permission.'); window.location.href='dashboard.php';</script>";
    exit();
}
$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pet Post</title>
    <style>
        /* Basic Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
            line-height: 1.6;
            padding: 20px;
        }
        
        /* Navigation Bar */
        nav {
            display: flex;
            justify-content: center;
            background-color: #ff6600;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        nav a:hover {
            text-decoration: underline;
        }
        
        h2 {
            color: #333;
            margin: 20px 0;
        }
        
        /* Form Container */
        .form-container {
            width: 80%;
            max-width: 600px;
            margin: 0 auto 30px;
            padding: 25px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #444;
        }
        
        input[type="text"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        
        textarea {
            height: 120px;
            resize: vertical;
        }
        
        /* Current Image Display */
        .current-image {
            margin: 15px 0;
            text-align: center;
        }
        
        .current-image img {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 3px;
        }
        
        /* Checkbox Styling */
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            width: 16px;
            height: 16px;
        }
        
        /* Button Styling */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        
        button {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        button[type="submit"] {
            background-color: #ff6600;
            color: white;
            flex-grow: 1;
            margin-right: 10px;
        }
        
        button[type="submit"]:hover {
            background-color: #e65c00;
        }
        
        .cancel-btn {
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-weight: bold;
            flex-grow: 1;
            margin-left: 10px;
            display: inline-block;
            text-align: center;
        }
        
        .cancel-btn:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home.html">Home</a>
        <a href="displaypets.php">Available Pets</a>
        <a href="dashboard.php">My Posts</a>
        <a href="#">Adoption Process</a>
        <a href="#">Contact Us</a>
        <a href="logout.php">Logout</a>
    </nav>
    
    <h2>Edit Pet Advertisement</h2>
    
    <div class="form-container">
        <form action="edit_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="postID" value="<?php echo htmlspecialchars($post['postID']); ?>">
            
            <div class="form-group">
                <label for="petName">Pet Name:</label>
                <input type="text" id="petName" name="petName" value="<?php echo htmlspecialchars($post['petName']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="Kitten" <?php if ($post['type'] == "Kitten") echo "selected"; ?>>Kitten</option>
                    <option value="Puppy" <?php if ($post['type'] == "Puppy") echo "selected"; ?>>Puppy</option>
                    <option value="Adult Cat" <?php if ($post['type'] == "Adult Cat") echo "selected"; ?>>Adult Cat</option>
                    <option value="Adult Dog" <?php if ($post['type'] == "Adult Dog") echo "selected"; ?>>Adult Dog</option>
                    <option value="Other" <?php if ($post['type'] == "Other") echo "selected"; ?>>Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($post['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Current Image:</label>
                <div class="current-image">
                    <img src="uploads/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['petName']); ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="petImage">Change Image (optional):</label>
                <input type="file" id="petImage" name="petImage" accept="image/*">
            </div>
            
            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="isPublished" value="1" <?php if ($post['isPublished']) echo "checked"; ?>> 
                    Make it public
                </label>
            </div>
            
            <div class="button-group">
                <button type="submit">Update Post</button>
                <a href="dashboard.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>