<?php
/**
 * Create Post Script
 *
 * This script handles the creation of new posts. It performs session validation
 * to ensure that the user is logged in. It retrieves user data based on the session,
 * handles form submission to create a new post, and inserts the post into the database.
 * After submission, it redirects the user back to the index page.
 */

// Include necessary files and perform session validation
session_start();
include('db.php');

// Logout logic
if (isset($_GET['logout'])) {
    // Destroy the session and redirect to index.php
    session_destroy();
    header("Location: index.php");
    exit();
}

// Assuming you have a user session, retrieve user data from the database based on the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE UserID = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userName = isset($user['Name']) ? $user['Name'] : ''; // Use isset() to check if 'Name' key exists
    } else {
        // Handle user not found
        header("Location: index.php");
        exit();
    }
} else {
    // Redirect to the login page if not logged in
    header("Location: index.php");
    exit();
}

// Handle form submission to create a new post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postContent = $_POST['post_content'];

    // Insert the new post into the database
    $insertSql = "INSERT INTO posts (user_id, post_content) VALUES ('$userId', '$postContent')";

    if ($conn->query($insertSql) === TRUE) {
        // Post created successfully, redirect to the posts page
        header("Location: index.php");
        exit();
    } else {
        echo "Error creating post: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Create Post</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .nav-button {
            text-decoration: none;
            padding: 10px;
            margin-right: 10px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .post-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .char-count {
            margin-top: 10px;
            color: #6c757d;
        }

        /* Responsive styles */
        @media only screen and (max-width: 768px) {
            .post-form {
                padding: 0 20px;
            }
        }
    </style>

</head>

<body>
    <nav>
        <a href="index.php" class="nav-button">Home</a>
        <a href="dashboard.php" class="nav-button">Dashboard</a>
        <a href="?logout" class="nav-button">Logout</a>
        <button onclick="goBack()" class="nav-button">Go Back</button>
    </nav>

    <!-- Post Form -->
    <div class="post-form">
        <h2>Create Post</h2>
        <form action="create-post.php" method="post" onsubmit="return validatePost()">
            <div class="mb-3">
                <label for="postContent" class="form-label">Post Content</label>
                <textarea class="form-control" id="postContent" name="post_content" rows="3" maxlength="280" required></textarea>
                <div class="char-count" id="charCount">0/280 characters</div>
            </div>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>

    <!-- Add other content as needed -->
    <script>
        function goBack() {
            window.history.back();
        }

        function validatePost() {
            // Validate post content length
            var postContent = document.getElementById('postContent').value;
            if (postContent.length > 280) {
                alert('Post content cannot exceed 280 characters.');
                return false;
            }
            return true;
        }

        // Update character count as the user types
        document.getElementById('postContent').addEventListener('input', function() {
            var charCount = document.getElementById('charCount');
            var postContent = this.value;
            charCount.textContent = postContent.length + '/280 characters';
        });
    </script>
</body>

</html>
