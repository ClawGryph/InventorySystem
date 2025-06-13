<?php
include "../db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_productName = trim($_POST["old_productName"]);
    $productName = trim($_POST["productName"]);
    $sellingPrice = trim($_POST["sellingPrice"]);

    $sql = "UPDATE products SET product_name=?, selling_price=? WHERE product_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $productName, $sellingPrice, $old_productName);
    if ($stmt->execute()) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>