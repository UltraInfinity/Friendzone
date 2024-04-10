<?php
/**
 * Update User Profile Page
 *
 * This page handles the update of user profile information. It retrieves the biography
 * and contact information from the submitted form and updates the corresponding fields
 * in the database for the logged-in user. It then redirects the user back to the dashboard.
 */

// Include necessary files and perform session validation
session_start();
include('db.php');

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get biography and contact information from the form
    $biography = $_POST['biography'];
    $contact = $_POST['contact'];

    // Assuming you have a user session, retrieve user ID from the session
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Update user profile data in the database
        $updateSql = "UPDATE users SET biography = '$biography', contact = '$contact' WHERE UserID = '$userId'";

        if ($conn->query($updateSql) === TRUE) {
            // Redirect back to the user's dashboard after updating profile
            header("Location: dashboard.php");
            exit();
        } else {
            // Display an error message if the profile update fails
            echo "Error updating profile: " . $conn->error;
        }
    } else {
        // Handle unauthorized access
        header("Location: index.php");
        exit();
    }
}
?>