<?php

/**
 * Database Configuration File
 *
 * This file contains the configuration parameters for connecting to the MySQL database.
 * It establishes a connection to the database server and checks if the connection is successful.
 * The $conn object can be used for database operations throughout the application.
 */

$servername = "127.0.0.1";  // Server IP address
$username = "root"; // Database username
$password = "root"; // Database password
$dbname = "friendzonedb"; // Database name


// Create a new MySQLi connection
// $conn = new mysqli($servername, $username, $password, $dbname);
$conn = new mysqli($servername, $username, $password, $dbname, 3307);

// Check if the connection was successful
if ($conn->connect_error) {
    // If the connection fails, terminate the script and display an error message
    die("Connection failed: " . $conn->connect_error);
}
