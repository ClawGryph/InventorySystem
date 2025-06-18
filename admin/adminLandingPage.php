<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <main>
        <!-- Side Bar -->
        <div>
            <a href="#">Dashboard</a>
            <a href="#">User Management</a>
            <a href="#">Purchases</a>
            <a href="#">Product</a>
            <a href="#">Sales</a>
            <a href="#">Sales Report</a>
        </div>

        <!-- Main Content -->
        <div>
            <a href="../index.php">Logout</a>
            <p>SALES: <span id="totalSales">₱0.00</span></p>
            <p>PROFIT: <span id="totalProfit">₱0.00</span></p>
            <p>PRODUCTS: <span id="totalProducts">0</span></p>
            <p>PURCHASES: <span id="totalPurchases">₱0.00</span></p>
            <div>
                <div>
                    <h2>Highest Selling Product</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody id="highestSellingProductBody">
                            <!-- Highest Selling Product will be populated here -->
                             <?php
                                include "../db.php";

                                // Get top 10 best-selling products by total quantity sold
                                $sql = "SELECT p.product_name, SUM(s.quantity) AS total_sold
                                        FROM sales s
                                        JOIN products p ON s.productID = p.productID
                                        GROUP BY s.productID
                                        ORDER BY total_sold DESC
                                        LIMIT 10";
                                $result = $conn->query($sql);
                                $no = 1;

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['total_sold']) . "</td>";
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2>Latest Sales</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody id="latestSalesBody">
                            <!-- Latest Sales will be populated here -->
                             <?php
                                include "../db.php";

                                // Get the latest sale (most recent dateSold)
                                $sql = "SELECT s.dateSold, p.product_name, s.totalPrice
                                        FROM sales s
                                        JOIN products p ON s.productID = p.productID
                                        ORDER BY s.dateSold DESC, s.salesID DESC
                                        LIMIT 10";
                                $result = $conn->query($sql);
                                $no = 1;

                                if ($row = $result->fetch_assoc()) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['dateSold']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['totalPrice']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4'>No sales found.</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="fetchingDashboardTotals.js"></script>
</body>
</html>