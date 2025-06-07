<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = trim($_POST["name"]);
    $purchasedItemId = intval($_POST["purchase_items"]);
    $buyingPrice = floatval($_POST["buying_price"]);
    $sellingPrice = floatval($_POST["sellingPrice"]);

    $sql = "INSERT INTO products (product_name, purchased_name, buying_price, selling_price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sidd", $productName, $purchasedItemId, $buyingPrice, $sellingPrice);

    if ($stmt->execute()) {
        header("Location: product.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>