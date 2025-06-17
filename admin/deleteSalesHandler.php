<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $salesID = intval($_POST["salesID"]);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM sales WHERE salesID = ?");
    $stmt->bind_param("i", $salesID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error: " . $stmt->error;
    }

    $stmt->close();
}
?>