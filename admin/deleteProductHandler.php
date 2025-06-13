<?php
include "../db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productID = intval($_POST["productID"]);

    $pisql = "DELETE FROM product_purchased_item WHERE productID = ?";
    $pistmt = $conn->prepare($pisql);
    $pistmt->bind_param("i", $productID);
    $pistmt->execute();
    $pistmt->close();

    $sql = "DELETE FROM products WHERE productID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>