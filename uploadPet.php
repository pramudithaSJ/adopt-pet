<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Pet Advertisement</title>
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
            font-size: 18px;
            transition: all 0.3s ease;
        }

        nav a:hover {
            text-decoration: underline;
        }

        /* Header Styling */
        h1 {
            color: #333;
            margin: 20px 0;
        }

        /* Pet Image */
        .cute-img {
            width: 120px;
            margin: 20px auto;
            display: block;
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
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        /* Labels */
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #444;
        }

        /* Form Inputs */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="file"] {
            padding: 10px 0;
        }

        /* Checkbox Styling */
        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            font-weight: normal;
            cursor: pointer;
        }

        .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
            cursor: pointer;
            width: 16px;
            height: 16px;
        }

        /* Dropdown Styling */
        select {
            background-color: #fff;
            cursor: pointer;
            padding: 10px;
        }

        /* Button Container */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Button Styling */
        .btn {
            padding: 12px 24px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
            flex-grow: 1;
            margin: 0 10px;
        }

        .btn-upload {
            background-color: #ff6600;
            color: white;
        }

        .btn-upload:hover {
            background-color: #e65c00;
        }

        .btn-cancel {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav>
        <a href="home.html">Home</a>
        <a href="displaypets.php">Available Pets</a>
        <a href="dashboard.php">My Posts</a>
        <a href="#">Adoption Process</a>
        <a href="#">Contact Us</a>
        <a href="login.php">Login</a>
    </nav>

    <h1>Post a Pet Advertisement</h1>
    <img src="Images/icon2.png" alt="Cute Pet" class="cute-img">

    <div class="form-container">
        <form action="upload_pet_process.php" method="POST" enctype="multipart/form-data">
            <!-- Pet Name Field -->
            <div class="form-group">
                <label for="petName">Pet Name:</label>
                <input type="text" id="petName" name="petName" placeholder="Enter pet name" required>
            </div>

            <!-- Pet Description Field -->
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" placeholder="Describe your pet" required></textarea>
            </div>

            <!-- Pet Type Selection -->
            <div class="form-group">
                <label for="type">Type:</label>
                <select id="type" name="type" required>
                    <option value="">Select pet type</option>
                    <option value="Kitten">Kitten</option>
                    <option value="Puppy">Puppy</option>
                    <option value="Adult Cat">Adult Cat</option>
                    <option value="Adult Dog">Adult Dog</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <!-- Pet Image Upload -->
            <div class="form-group">
                <label for="petImage">Upload Picture:</label>
                <input type="file" id="petImage" name="petImage" accept="image/*" required>
            </div>

            <!-- Publication Status Checkbox -->
            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="isPublished" value="1"> 
                    Make it public (check to publish immediately)
                </label>
            </div>

            <!-- Form Buttons -->
            <div class="button-group">
                <button type="submit" class="btn btn-upload">Submit Advertisement</button>
                <button type="reset" class="btn btn-cancel">Clear Form</button>
            </div>
        </form>
    </div>
</body>

</html>