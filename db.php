<?php
// Database connection settings
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'inventorysystem';

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>