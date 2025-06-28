<?php
include "../db.php";

// Total Sales (sum of all sales)
$salesResult = $conn->query("SELECT SUM(totalPrice) AS totalSales FROM sales");
$totalSales = $salesResult->fetch_assoc()['totalSales'] ?? 0;

// Total Purchases (sum of all original purchases)
$purchasesResult = $conn->query("SELECT SUM(price * total_stock) AS totalPurchases FROM purchaseditem");
$totalPurchases = $purchasesResult->fetch_assoc()['totalPurchases'] ?? 0;

// Total Purchases base on products sold
$purchaseProductsResult = $conn->query("SELECT SUM(p.buying_price * s.quantity) AS totalBuyingPrice FROM sales s JOIN products p ON p.productID = s.productID");
$totalPurchasesProducts = $purchaseProductsResult->fetch_assoc()['totalBuyingPrice'] ?? 0;

// Total Profit (sales - purchases related to sales)
$totalProfit = $totalSales - $totalPurchasesProducts;

// Total Products Sold (sum of all quantities sold)
$productsResult = $conn->query("SELECT SUM(quantity) AS totalProducts FROM sales");
$totalProducts = $productsResult->fetch_assoc()['totalProducts'] ?? 0;

// Return as JSON
echo json_encode([
    "totalSales" => $totalSales,
    "totalPurchases" => $totalPurchases,
    "totalProfit" => $totalProfit,
    "totalProducts" => $totalProducts,
    "totalPurchasesProducts" => $totalPurchasesProducts
]);
?>
