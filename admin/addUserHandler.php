<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $username = trim($_POST["username"]);
    $passwordInput = trim($_POST["password"]);
    $role = trim($_POST["role"]);

    // Hash the password securely
    $passwordHash = password_hash($passwordInput, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (fullname, username, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullname, $username, $passwordHash, $role);

    if ($stmt->execute()) {
        header("Location: adminLandingPage.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
