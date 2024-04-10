<?php

/**
 * User Dashboard Script
 *
 * This script represents the user dashboard, displaying user information and posts.
 * It includes session validation, retrieves user data from the database, and fetches
 * user-specific posts. Users can also logout, create new posts, and edit their profiles
 * directly from this dashboard.
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
        $userName = isset($user['Name']) ? $user['Name'] : '';
        $userBio = isset($user['biography']) ? $user['biography'] : ''; // Retrieve bio from the database
        $userContact = isset($user['contact']) ? $user['contact'] : ''; // Retrieve contact details from the database
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

// Fetch user's posts
$sqlUserPosts = "SELECT * FROM posts WHERE user_id = '$userId' ORDER BY created_at DESC";
$resultUserPosts = $conn->query($sqlUserPosts);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>User Dashboard</title>

    <style>
        /* Common styles for both desktop and mobile */
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

        h2 {
            color: #007bff;
        }

        .user-info,
        .user-posts {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .post {
            position: relative;
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .delete-post {
            position: absolute;
            top: 25px;
            right: 5px;
            color: #f00;
            /* Red color for the delete button */
            cursor: pointer;
            border: none;
            border-radius: 5px;
            padding: 10px;
            margin-right: 10px;
            background-color: #ddd;
        }

        small {
            color: #6c757d;
        }

        /* Mobile-specific styles */
        @media only screen and (max-width: 600px) {
            nav {
                flex-direction: column;
                align-items: center;
            }

            .nav-button {
                margin-bottom: 10px;
            }

            .delete-post {
                top: 10px;
                right: 5px;
                padding: 5px;
            }
        }
    </style>

</head>

<body>
    <nav>
        <a href="index.php" class="nav-button">Home</a>
        <a href="edit-profile.php" class="nav-button">Edit Profile</a>
        <a href="create-post.php" class="nav-button">Create Post</a>
        <a href="?logout" class="nav-button">Logout</a>
        <button onclick="goBack()" class="nav-button">Go Back</button>
    </nav>

    <h2>Welcome, <?php echo $userName; ?>!</h2>

    <!-- User's Information Section -->
    <div class="user-info">
        <h3>Your Information:</h3>
        <p><strong>Bio:</strong> <?php echo $userBio; ?></p>
        <p><strong>Contact Details:</strong> <?php echo $userContact; ?></p>
    </div>

    <!-- User's Posts Section -->
    <div class="user-posts">
        <h3>Your Posts:</h3>
        <?php
        while ($rowPost = $resultUserPosts->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<span class='delete-post' onclick='deletePost({$rowPost['PostID']})'>Delete</span>";
            echo "<p>{$rowPost['post_content']}</p>";
            echo "<p><small>Posted on: {$rowPost['created_at']}</small></p>";
            echo "</div>";
        }
        ?>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }

        function deletePost(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                // Redirect to a PHP script to handle post deletion
                window.location.href = `delete-post.php?PostID=${postId}`;
            }
        }
    </script>
</body>

</html>