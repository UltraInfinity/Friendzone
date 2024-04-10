<?php
/**
 * User Registration Page
 *
 * This page handles user registration by processing the submitted registration form.
 * It checks if the provided email is already in use, and if not, it inserts the new user
 * into the database with hashed password. It displays appropriate messages based on the result.
 */

// Start the session
session_start();

// Include the database connection file
include('db.php');

// Define variable to hold password complexity error message
$password_error = '';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user registration data from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Password complexity requirements
    if (!preg_match("/^(?=.*\d)(?=.*[\W_])[^\s]{8,}$/", $password)) {
        // Password does not meet complexity requirements
        $password_error = "Password must be at least 8 characters long and contain at least one digit and one special character.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the provided email is already in use
        $checkEmail = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            // Display error message if email is already in use
            echo "Email already in use. Please choose another email.";
        } else {
            // Insert new user into the database
            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                // Registration successful
                echo "Registration successful!";
            } else {
                // Display error message if registration fails
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML form for registration -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>User Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            color: #007bff;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- User Registration Form -->
        <form action="register.php" method="post">
            <div class="mb-3">
                <label for="name">Name:</label>
                <input type="text" name="name" required class="form-control" id="InputName1">
            </div>
            <div class="mb-3">
                <label for="InputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="InputEmail1" aria-describedby="emailHelp" name="email" required>
            </div>
            <div class="mb-3">
                <label for="InputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="InputPassword1" name="password" required>
                <?php if ($password_error): ?>
                    <p style="color: red;"><?php echo $password_error; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <p class="mt-2">Already have an account? <a href="login.php">Login to existing account</a></p>
        </form>
    </div>
</body>

</html>
