<?php
    include "../db.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]);
        $quantity = trim($_POST["quantity"]);
        $purchase_price = trim($_POST["purchase_price"]);

        // Validate inputs
        if (empty($name) || empty($quantity) || empty($purchase_price)) {
            echo "All fields are required.";
            exit();
        }

        // Prepare and execute the SQL statement
        $sql = "INSERT INTO purchaseditem (purchased_name, stock, price, dateAdded) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sid", $name, $quantity, $purchase_price);

        if ($stmt->execute()) {
            echo "Purchase item added successfully.";
            header("Location: adminLandingPage.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    else {
        echo "Invalid request method.";
    }
?>