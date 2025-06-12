<?php
file_put_contents('debug_edit.txt', print_r($_POST, true));
include "../db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_username = trim($_POST["old_username"]);
    $username = trim($_POST["username"]);
    $fullname = trim($_POST["fullname"]);
    $role = trim($_POST["role"]);

    $sql = "UPDATE users SET fullname=?, username=?, role=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullname, $username, $role, $old_username);
    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>