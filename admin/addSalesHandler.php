<?php
    include "../db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $productID = intval($_POST["productID"]);
        $quantity = intval($_POST["quantity"]);
        $dateSold = date("Y-m-d H:i:s");

        // Get selling price from products table
        $stmt = $conn->prepare("SELECT selling_price FROM products WHERE productID = ?");
        $stmt->bind_param("i", $productID);
        $stmt->execute();
        $stmt->bind_result($sellingPrice);
        $stmt->fetch();
        $stmt->close();

        $total = $sellingPrice * $quantity;

        // Insert into sales table
        $insert = $conn->prepare("INSERT INTO sales (productID, quantity, totalPrice, dateSold) VALUES (?, ?, ?, ?)");
        $insert->bind_param("iids", $productID, $quantity, $total, $dateSold);

        if ($insert->execute()) {
            // 1. Get the purchased item linked to this product
            $relSql = "SELECT itemID FROM product_purchased_item WHERE productID = ?";
            $relStmt = $conn->prepare($relSql);
            $relStmt->bind_param("i", $productID);
            $relStmt->execute();
            $relResult = $relStmt->get_result();

            // 2. Decrease stock for each purchased item
            while ($relRow = $relResult->fetch_assoc()) {
                $purchasedItemID = $relRow['itemID'];
                $updateSql = "UPDATE purchaseditem SET stock = stock - ? WHERE itemID = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ii", $quantity, $purchasedItemID);
                $updateStmt->execute();
                $updateStmt->close();
            }
            $relStmt->close();

            header("Location: adminLandingPage.php");
            exit();
        } else {
            echo "Error: " . $insert->error;
        }
    }
?>