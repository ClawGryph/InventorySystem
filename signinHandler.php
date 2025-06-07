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
        if($inputPassword === "admin"){
            $_SESSION["user"] = $username;

            // Update last_login for admin
            $updateSql = "UPDATE users SET lastLogin = NOW() WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("s", $username);
            $updateStmt->execute();

            // Redirect to the admin landing page
            header("Location: ./admin/adminLandingPage.php");
            exit();
        }else if (password_verify($inputPassword, $storedHash)) {
            $_SESSION["user"] = $username;

            // Update last_login for regular user
            $updateSql = "UPDATE users SET lastLogin = NOW() WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("s", $username);
            $updateStmt->execute();

            // Redirect to the landing page for regular users
            header("Location: landingPage.php");
            exit();
        }
    }
    
    echo "Invalid username or password.";
}
?>