<?php
include "../db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $itemID = intval($_POST["itemID"]);
    $oldPurchasedName = trim($_POST["old_purchasedName"]);
    $purchasedName = trim($_POST["purchasedName"]);
    $stock = intval($_POST["stock"]);
    $purchasedPrice = floatval($_POST["purchasedPrice"]);

    // Check if another row (different itemID) has same name and price
    $checkSql = "SELECT itemID, stock, total_stock FROM purchaseditem WHERE purchased_name = ? AND price = ? AND itemID != ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("sdi", $purchasedName, $purchasedPrice, $itemID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Match found → merge
        $existing = $checkResult->fetch_assoc();
        $newStock = $stock;
        $newTotalStock = $stock;

        // Update existing row with new stock and total_stock
        $updateStmt = $conn->prepare("UPDATE purchaseditem SET stock = ?, total_stock = ? WHERE itemID = ?");
        $updateStmt->bind_param("iii", $newStock, $newTotalStock, $existing['itemID']);
        $updateStmt->execute();
        $updateStmt->close();

        // Delete current row
        $deleteStmt = $conn->prepare("DELETE FROM purchaseditem WHERE itemID = ?");
        $deleteStmt->bind_param("i", $itemID);
        $deleteStmt->execute();
        $deleteStmt->close();

        echo "merged";
    } else {
        // No match → update original row
        $updateSql = "UPDATE purchaseditem SET purchased_name = ?, stock = ?, total_stock = ?, price = ? WHERE itemID = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("siidi", $purchasedName, $stock, $stock, $purchasedPrice, $itemID);

        if ($updateStmt->execute()) {
            echo "success";
        } else {
            http_response_code(500);
            echo "error";
        }

        $updateStmt->close();
    }
}
?>