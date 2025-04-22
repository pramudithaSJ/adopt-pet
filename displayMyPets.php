<?php
include 'db.php';

// Get only published my post session id's posts
session_start();
$ownerID = $_SESSION['user_id'] ?? null; // Get owner ID from session

if (!$ownerID) {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit();
}

// Fetch posts from the database
$sql = "SELECT * FROM posts WHERE ownerID = ? ORDER BY postID DESC"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ownerID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Pet Posts | Dashboard</title>
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
            padding-bottom: 30px;
        }
        
        /* Navigation Bar */
        nav {
            display: flex;
            justify-content: center;
            background-color: #ff6600;
            padding: 15px;
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
        
        h1 {
            margin: 20px 0;
            color: #333;
        }
        
        /* Pet Posts Container */
        .pet-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
            padding: 0 15px;
        }
        
        /* Pet Card Styling */
        .pet-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            width: 300px;
            text-align: center;
            background-color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .pet-card:hover {
            transform: translateY(-5px);
        }
        
        .pet-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .pet-card h3 {
            color: #ff6600;
            margin: 10px 0;
        }
        
        .pet-card p {
            color: #555;
            margin: 8px 0;
            text-align: left;
        }
        
        .pet-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .published {
            background-color: #d4edda;
            color: #155724;
        }
        
        .unpublished {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        /* Action Links */
        .links {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }
        
        .links a {
            display: inline-block;
            text-decoration: none;
            margin: 0 10px;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        
        .edit-link {
            background-color: #f0ad4e;
            color: white;
        }
        
        .delete-link {
            background-color: #d9534f;
            color: white;
        }
        
        .links a:hover {
            opacity: 0.8;
            transform: scale(1.05);
        }
        
        /* Empty state message */
        .empty-state {
            text-align: center;
            margin: 40px auto;
            color: #6c757d;
            max-width: 500px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .add-new-btn {
            display: inline-block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #ff6600;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        
        .add-new-btn:hover {
            background-color: #e65c00;
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
    
    <h1>My Pet Posts</h1>
    

    
    <div class="pet-container">
        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="pet-card">
                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['petName']); ?>">
                    <h3><?php echo htmlspecialchars($row['petName']); ?></h3>
                    
                    <!-- Status indicator -->
                    <span class="pet-status <?php echo $row['isPublished'] ? 'published' : 'unpublished'; ?>">
                        <?php echo $row['isPublished'] ? 'Published' : 'Not Published'; ?>
                    </span>
                    
                    <p><strong>Type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    
                    <div class="links">
                        <a href="editPet.php?postID=<?php echo $row['postID']; ?>" class="edit-link">Edit</a>
                        <a href="delete_process.php?postID=<?php echo $row['postID']; ?>" 
                           onclick="return confirm('Are you sure you want to delete this post?');" 
                           class="delete-link">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <h3>No pet posts yet!</h3>
                <p>Start by adding your first pet for adoption.</p>
                <a href="uploadPet.php" class="add-new-btn">Add Your First Pet</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>