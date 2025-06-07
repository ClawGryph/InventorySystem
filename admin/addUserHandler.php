<?php
    include "../db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST["username"]);
        $passwordInput = trim($_POST["password"]);
        $role = trim($_POST["role"]);

        // Use password_hash instead of manual hashing and salting
        $passwordHash = password_hash($passwordInput, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $passwordHash, $role);

        if ($stmt->execute()) {
            echo "Signup successful";
            header("Location: userManagement.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
?>