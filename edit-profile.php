<?php
/**
 * Edit Profile Page
 *
 * This page allows users to edit their profile information. It includes a form with
 * fields for the user's biography and contact number. The current user's data is retrieved
 * from the database based on the session. If the user is not logged in, unauthorized access
 * is handled by redirecting to the index.php page. The form data is then pre-filled with the
 * user's existing information. Upon submission, the form data is sent to the "update-profile.php"
 * script for processing.
 */

// Include necessary files and perform session validation
session_start();
include('db.php');

// Assuming you have a user session, retrieve user data from the database based on the session
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $sql = "SELECT * FROM users WHERE UserID = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $userBiography = $user['biography'];
        $userContact = $user['contact'];
    } else {
        // Handle user not found
        header("Location: index.php");
        exit();
    }
} else {
    // Handle unauthorized access
    header("Location: index.php");
    exit();
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
    <title>Edit Profile</title>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        textarea,
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:first-child {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <!-- Edit Profile Form -->
    <form action="update-profile.php" method="post">
        <label for="biography">Biography:</label>
        <textarea name="biography" rows="4" cols="50"><?php echo $userBiography; ?></textarea>

        <label for="contact">Contact Number:</label>
        <input type="tel" name="contact" value="<?php echo $userContact; ?>" pattern="[0-9]{10}" required>

        <!-- Add additional fields for other profile information if needed -->
        <button onclick="goBack()">Go Back</button>
        <button type="submit">Save Changes</button>
    </form>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
