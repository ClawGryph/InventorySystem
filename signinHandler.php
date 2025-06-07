<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $inputPassword = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $storedHash = $row["password"];

        // Use password_verify() to check the password
        if (password_verify($inputPassword, $storedHash)) {
            $_SESSION["user"] = $username;
            header("Location: dashboard.php");
            exit();
        }
    }
    
    echo "Invalid username or password.";
}
?>