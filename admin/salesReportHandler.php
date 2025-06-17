<?php
include "../db.php";

$grandTotal = 0;
$profit = 0;

$search = isset($_POST['search']) ? trim($_POST['search']) : '';
$startDate = isset($_POST['startDate']) ? trim($_POST['startDate']) : '';
$endDate = isset($_POST['endDate']) ? trim($_POST['endDate']) : '';

$sql = "SELECT s.dateSold, p.product_name AS 'Product_Name', p.buying_price, p.selling_price, 
               SUM(s.quantity) AS 'Total_Quantity', SUM(s.totalPrice) AS 'Total' 
        FROM sales s 
        JOIN products p ON s.productID = p.productID 
        WHERE 1";

$params = [];
$types = "";

if ($search !== "") {
    $sql .= " AND p.product_name LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}
if ($startDate !== "") {
    $sql .= " AND s.dateSold >= ?";
    $params[] = $startDate;
    $types .= "s";
}
if ($endDate !== "") {
    $sql .= " AND s.dateSold <= ?";
    $params[] = $endDate;
    $types .= "s";
}

$sql .= " GROUP BY s.dateSold, p.product_name, p.buying_price, p.selling_price 
          ORDER BY s.dateSold DESC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['dateSold']) . "</td>";
        echo "<td>" . htmlspecialchars(ucfirst($row['Product_Name'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['buying_price']) . "</td>";
        echo "<td>" . htmlspecialchars($row['selling_price']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Total_Quantity']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Total']) . "</td>";
        echo "</tr>";

        $grandTotal += $row['Total'];
        $profit += ($row['selling_price'] - $row['buying_price']) * $row['Total_Quantity'];
    }
    echo "<tr>";
    echo "<td colspan='5' style='text-align:right'><strong>GRAND TOTAL</strong></td>";
    echo "<td><strong>" . number_format($grandTotal, 2) . "</strong></td>";
    echo "</tr>";

    echo "<tr>";
    echo "<td colspan='5' style='text-align:right'><strong>PROFIT</strong></td>";
    echo "<td><strong>" . number_format($profit, 2) . "</strong></td>";
    echo "</tr>";
} else {
    echo "<tr><td colspan='6'>No sales data available.</td></tr>";
}
?>