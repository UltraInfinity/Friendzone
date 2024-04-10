<?php
/**
 * Comment Submission Script
 *
 * This script handles the submission of comments to posts. It performs session validation
 * to ensure that the user is logged in. It validates the form data, sanitizes inputs, and
 * inserts the comment into the database. After submission, it redirects the user back to
 * the index page.
 */

// Start the session and include necessary files
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to the index page
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the input data
    $postID = $_POST['PostID'];
    $commentContent = $_POST['comment_content'];

    // Sanitize the data to prevent SQL injection
    $postID = mysqli_real_escape_string($conn, $postID);
    $commentContent = mysqli_real_escape_string($conn, $commentContent);

    // Insert the comment into the database
    $userID = $_SESSION['user_id'];
    $timestamp = date("Y-m-d H:i:s");
    $insertCommentQuery = "INSERT INTO comments (PostID, UserID, content, timestamp) 
                           VALUES ('$postID', '$userID', '$commentContent', '$timestamp')";

    // Check if the comment insertion was successful
    if ($conn->query($insertCommentQuery) === TRUE) {
        // Redirect back to the index page after adding the comment
        header("Location: index.php");
        exit();
    } else {
        // Handle the error if the comment insertion fails
        echo "Error: " . $insertCommentQuery . "<br>" . $conn->error;
    }
} else {
    // If the form is not submitted, redirect to index.php
    header("Location: index.php");
    exit();
}
?>
