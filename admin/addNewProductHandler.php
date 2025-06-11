<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = trim($_POST["name"]);
    $buyingPrice = floatval($_POST["buying_price"]);
    $sellingPrice = floatval($_POST["sellingPrice"]);
    $purchasedItemIds = $_POST["purchase_items"];

    $sql = "INSERT INTO products (product_name, buying_price, selling_price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdd", $productName, $buyingPrice, $sellingPrice);

    if ($stmt->execute()) {
        $productID = $stmt->insert_id;

        foreach ($purchasedItemIds as $purchasedItemId) {
            $insertPurchasedItem = $conn->prepare("INSERT INTO product_purchased_item (productID, itemID) VALUES (?, ?)");
            $insertPurchasedItem->bind_param("ii", $productID, $purchasedItemId);
            $insertPurchasedItem->execute();
            $insertPurchasedItem->close();
        }

        header("Location: product.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>