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
            <p>PURCHASES: <span id="totalPurchases">₱0.00</span></p>
            <p>PROFIT: <span id="totalProfit">₱0.00</span></p>
            <p>PRODUCTS: <span id="totalProducts">₱0.00</span></p>

            <div>
                <div>
                    <h2>Highest Selling Product</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody id="highestSellingProductBody">
                            <!-- Highest Selling Product will be populated here -->
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2>Latest Sales</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody id="latestSalesBody">
                            <!-- Latest Sales will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>