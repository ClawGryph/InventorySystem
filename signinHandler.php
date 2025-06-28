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
        $role = strtolower($row["role"]);

        // Use password_verify() to check the password
        if (password_verify($inputPassword, $storedHash)) {
            $_SESSION["user"] = $username;
            $_SESSION["role"] = $role;
            $_SESSION["userID"] = $row["userID"]; 

            // Update last_login for regular user
            $updateSql = "UPDATE users SET lastLogin = NOW() WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("s", $username);
            $updateStmt->execute();

            // Redirect base on role
            if($role === "admin"){
                header("Location: ./admin/adminlandingPage.php");
            } else{
                header("Location: ./user/userLandingPage.php");
            }
            exit();
        }
    }
    
    header("Location: index.php?error=1");
    exit();
}
?>