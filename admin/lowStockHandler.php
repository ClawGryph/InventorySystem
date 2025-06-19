<?php
include "../db.php";

$sql = "SELECT purchased_name, stock FROM purchaseditem WHERE stock < 4";
$result = $conn->query($sql);

$lowStock = [];
while ($row = $result->fetch_assoc()) {
    $lowStock[] = $row['purchased_name'] . " (Stock: " . $row['stock'] . ")";
}

echo json_encode($lowStock);
?>