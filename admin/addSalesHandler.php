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
            header("Location: sales.php");
            exit();
        } else {
            echo "Error: " . $insert->error;
        }
    }
?>