<?php
file_put_contents('debug_delete.txt', print_r($_POST, true));
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = intval($_POST["itemID"]);

    // 1. Get the price and quantity of the purchased item
    $stmt = $conn->prepare("SELECT price FROM purchaseditem WHERE itemID = ?");
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $stmt->bind_result($price);
    if ($stmt->fetch()) {
        $totalDeduct = $price;
    } else {
        echo "error";
        exit();
    }
    $stmt->close();

    // 2. Find all products that use this purchased item
    $stmt = $conn->prepare("SELECT productID FROM product_purchased_item WHERE itemID = ?");
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $result = $stmt->get_result();
    $productIDs = [];
    while ($row = $result->fetch_assoc()) {
        $productIDs[] = $row['productID'];
    }
    $stmt->close();

    // 3. Deduct the total price from each product's buying_price
    foreach ($productIDs as $productID) {
        $update = $conn->prepare("UPDATE products SET buying_price = GREATEST(buying_price - ?, 0) WHERE productID = ?");
        $update->bind_param("di", $totalDeduct, $productID);
        $update->execute();
        $update->close();
    }

    // 4. Delete the product-purchased item relationship
    $del = $conn->prepare("DELETE FROM product_purchased_item WHERE itemID = ?");
    $del->bind_param("i", $itemID);
    $del->execute();
    $del->close();

    // 5. Delete the purchased item
    $stmt = $conn->prepare("DELETE FROM purchaseditem WHERE itemID = ?");
    $stmt->bind_param("i", $itemID);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
?>