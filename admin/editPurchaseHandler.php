<?php
include "../db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_purchasedName = trim($_POST["old_purchasedName"]);
    $purchasedName = trim($_POST["purchasedName"]);
    $stock = trim($_POST["stock"]);
    $purchasedPrice = trim($_POST["purchasedPrice"]);

    $sql = "UPDATE purchaseditem SET purchased_name=?, stock=?, price=? WHERE purchased_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sids", $purchasedName, $stock, $purchasedPrice, $old_purchasedName);
    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>