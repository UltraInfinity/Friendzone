<?php
/**
 * Friendzone - All Posts Page
 *
 * This page displays all posts, allows users to search for other users by name,
 * and provides functionalities for viewing posts, commenting, and searching. Users
 * can only access the search feature if they are logged in. The page includes sections
 * for displaying all posts, searching for users, and commenting on posts.
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

// Search logic (only if the user is logged in)
$searchResult = null;
if (isset($_SESSION['user_id']) && $_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];

    // Perform a search query based on the provided name
    $searchQuery = "SELECT * FROM users WHERE Name LIKE '%$searchTerm%'";
    $searchResult = $conn->query($searchQuery);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendzone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Add additional styles and scripts if needed -->

    <style>
    /* Common styles for both desktop and mobile */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        padding: 20px;
    }

    h1.header {
        color: #007bff;
        text-align: center;
    }

    .header-buttons {
        margin-bottom: 20px;
        text-align: center;
    }

    .post {
        background-color: #fff;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    h2 {
        color: #007bff;
    }

    small {
        color: #6c757d;
    }

    button {
        margin-right: 10px;
    }

    .search-container {
        margin-top: 20px;
        text-align: center;
    }

    .search-container input {
        padding: 10px;
        margin-right: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 60%; /* Adjust width for better responsiveness */
    }

    .search-container button {
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    .search-results {
        margin-top: 20px;
    }

    .search-result {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .comment-container {
        margin-top: 10px;
    }

    .comment-container textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: none;
    }

    .comment-container button {
        padding: 10px;
        margin-top: 5px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }

    .comment {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
    }

    .comment small {
        color: #6c757d;
        display: block;
        margin-top: 5px;
    }

    /* Mobile-specific styles */
    @media only screen and (max-width: 600px) {
        .search-container input {
            width: 100%; /* Full width on smaller screens */
        }
    }
    </style>

</head>

<body>
    <h1 class="header">Friendzone</h1>
    <?php
    include('db.php');

    // Check if the user is logged in
    $loggedIn = isset($_SESSION['user_id']);

    // Display login/register buttons if not logged in
    if (!$loggedIn) {
        echo "<div class='header-buttons'>";
        echo "<button class='btn btn-primary' onclick=\"location.href='index.php'\">Home</button>";
        echo "<button class='btn btn-primary' onclick=\"location.href='login.php'\">Login</button>";
        echo "<button class='btn btn-primary' onclick=\"location.href='register.php'\">Register</button>";
        echo "</div>";
    } else {
        // Display profile and create post buttons if logged in
        echo "<div class='header-buttons'>";
        echo "<button class='btn btn-primary' onclick=\"location.href='index.php'\">Home</button>";
        echo "<button class='btn btn-primary' onclick=\"location.href='dashboard.php'\">Profile</button>";
        echo "<button class='btn btn-primary' onclick=\"location.href='create-post.php'\">Create Post</button>";
        echo "</div>";
    }
    ?>

    <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="search-container">
            <form action="index.php" method="get">
                <input type="text" name="search" placeholder="Search by name">
                <button type="submit">Search</button>
            </form>
        </div>

        <?php if (isset($searchResult)) : ?>
            <div class="search-results">
                <h3>Search Results:</h3>
                <?php while ($row = $searchResult->fetch_assoc()) : ?>
                    <p>Name: <?php echo $row['Name']; ?> | Email: <?php echo $row['email']; ?></p>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <p>Please log in to use the search feature.</p>
    <?php endif; ?>

    <!-- Display All Posts Section -->
    <h2>All Posts:</h2>
    <?php
    // Fetch all posts ordered by the date posted
    $sqlPosts = "SELECT posts.*, users.Name as UserName FROM posts JOIN users ON posts.user_id = users.UserID ORDER BY created_at DESC";
    $resultPosts = $conn->query($sqlPosts);

    while ($rowPost = $resultPosts->fetch_assoc()) {
        echo "<div class='post'>";
        echo "<p>{$rowPost['post_content']}</p>";
        echo "<p><small>Posted on: {$rowPost['created_at']} by {$rowPost['UserName']}</small></p>";

        // Comment Section
        if ($loggedIn) {
            echo "<div class='comment-container'>";
            echo "<form action='add-comment.php' method='post'>";
            echo "<input type='hidden' name='PostID' value='{$rowPost['PostID']}'>";
            echo "<textarea name='comment_content' placeholder='Write a comment'></textarea>";
            echo "<button type='submit'>Comment</button>";
            echo "</form>";
            echo "</div>";
        }

        // Display Comments
        $postId = $rowPost['PostID'];
        $sqlComments = "SELECT comments.*, users.Name as UserName FROM comments JOIN users ON comments.UserID = users.UserID WHERE PostID = '$postId' ORDER BY timestamp DESC";
        $resultComments = $conn->query($sqlComments);

        while ($rowComment = $resultComments->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p>{$rowComment['content']}</p>";
            echo "<p><small>Commented by: {$rowComment['UserName']} | {$rowComment['timestamp']}</small></p>";
            echo "</div>";
        }

        echo "</div>"; // Close post div
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
