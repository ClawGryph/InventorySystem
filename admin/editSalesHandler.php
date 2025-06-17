<?php
include "../db.php";

file_put_contents('debug_update.txt', print_r($_POST, true));

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $salesID = intval($_POST["salesID"]);
    $soldProductName = trim($_POST["soldProductName"]);
    $quantity = trim($_POST["quantity"]);

    $stmt = $conn->prepare("SELECT productID, selling_price FROM products WHERE product_name = ?");
    $stmt->bind_param("s", $soldProductName);
    $stmt->execute();
    $stmt->bind_result($productID, $sellingPrice);

    if(!$stmt->fetch()) {
        echo "Product not found";
        http_response_code(400);
        exit();
    }
    $stmt->close();
   
    $totalPrice = $sellingPrice * $quantity;

    $sdb = $conn->prepare("UPDATE sales SET productID = ?, quantity = ?, totalPrice = ? WHERE salesID = ?");
    $sdb->bind_param("iidi", $productID, $quantity, $totalPrice, $salesID);

    if ($sdb->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error" .  $sdb->error;
    }
    $sdb->close();
}

?>