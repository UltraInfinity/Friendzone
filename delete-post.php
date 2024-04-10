<?php
/**
 * Delete Post Script
 *
 * This script handles the deletion of a user's post. It performs session validation to
 * ensure the user is logged in. It then checks if the post_id is provided in the query
 * string. If provided, it checks whether the post belongs to the logged-in user before
 * deleting it. After deleting the post, the script redirects the user to the dashboard.
 */

// Include necessary files and perform session validation
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Check if post_id is provided in the query string
if (isset($_GET['PostID'])) {
    $postId = $_GET['PostID'];

    // Get the user_id of the logged-in user
    $userId = $_SESSION['user_id'];

    // Check if the post belongs to the logged-in user
    $checkOwnership = "SELECT * FROM posts WHERE PostID = '$postId' AND user_id = '$userId'";
    $resultOwnership = $conn->query($checkOwnership);

    if ($resultOwnership->num_rows > 0) {
        // Delete the post
        $deletePostQuery = "DELETE FROM posts WHERE PostID = '$postId'";
        if ($conn->query($deletePostQuery) === TRUE) {
            // Post deleted successfully
            header("Location: dashboard.php");
            exit();
        } else {
            // Error deleting post
            echo "Error: " . $conn->error;
        }
    } else {
        // The post doesn't belong to the logged-in user
        header("Location: dashboard.php");
        exit();
    }
} else {
    // post_id not provided in the query string
    header("Location: dashboard.php");
    exit();
}

$conn->close();
?>
