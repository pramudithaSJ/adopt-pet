<?php
include 'db.php';

// Get only published posts
$sql = "SELECT * FROM posts WHERE isPublished = 1";
$result = $conn->query($sql);

// Check if there are any available pets
$has_pets = ($result && $result->num_rows > 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Pets</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #ff6600;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-size: 18px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        nav a:hover {
            transform: translateY(-2px);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #444;
            margin: 30px 0;
        }

        .pet-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            margin: 30px auto;
            max-width: 1200px;
            padding: 0 15px;
        }

        .pet-card {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            width: 280px;
            text-align: center;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .pet-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .pet-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .pet-card h3 {
            color: #ff6600;
            margin: 10px 0;
            font-size: 22px;
        }
        
        .pet-card p {
            color: #555;
            margin: 8px 0;
            line-height: 1.4;
        }

        .email-button {
            margin-top: 15px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ff6600;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .email-button:hover {
            background-color: #e55c00;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            margin: 40px auto;
            max-width: 600px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .empty-state h2 {
            color: #ff6600;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .empty-state-icon {
            font-size: 60px;
            color: #ff6600;
            margin-bottom: 20px;
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
        <a href="login.php">Login</a>
    </nav>
    
    <h1>Available Pets for Adoption</h1>

    <?php if ($has_pets): ?>
        <div class="pet-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="pet-card">
                    <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['petName']; ?>">
                    <h3><?php echo $row['petName']; ?></h3>
                    <p><strong>Type:</strong> <?php echo $row['type']; ?></p>
                    <p><strong>Description:</strong> <?php echo $row['description']; ?></p>
                    <button class="email-button" onclick="sendEmail('<?php echo $row['petName']; ?>', 'info@adoptpet.com')">Contact Owner</button>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">🐾</div>
            <h2>No Pets Available Right Now</h2>
            <p>We don't have any pets listed for adoption at the moment. Please check back later or contact us to be notified when new pets become available.</p>
            <button class="email-button" onclick="window.location.href='#'">Notify Me About New Pets</button>
        </div>
    <?php endif; ?>

    <script>
        function sendEmail(petName, email) {
            window.location.href = `mailto:${email}?subject=Interested in Adopting ${petName}`;
        }
    </script>
</body>
</html>