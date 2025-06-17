<?php
include "../db.php";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$startDate = isset($_GET['startDate']) ? trim($_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? trim($_GET['endDate']) : '';

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="sales_report.csv"');

$output = fopen("php://output", "w");

// CSV header
fputcsv($output, ['Date', 'Product Name', 'Buying Price', 'Selling Price', 'Total Quantity', 'Total']);

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

$grandTotal = 0;
$profit = 0;

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $row['dateSold'],
            ucfirst($row['Product_Name']),
            $row['buying_price'],
            $row['selling_price'],
            $row['Total_Quantity'],
            $row['Total']
        ]);

        $grandTotal += $row['Total'];
        $profit += ($row['selling_price'] - $row['buying_price']) * $row['Total_Quantity'];
    }

    // Empty row for spacing
    fputcsv($output, []);

    // Grand Total row
    fputcsv($output, ['', '', '', '', 'GRAND TOTAL', number_format($grandTotal, 2)]);

    // Profit row
    fputcsv($output, ['', '', '', '', 'PROFIT', number_format($profit, 2)]);
} else {
    fputcsv($output, ['No sales data available.']);
}

fclose($output);
exit;
?>
