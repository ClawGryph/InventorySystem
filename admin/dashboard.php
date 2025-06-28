
<div class="section">
    <div id="dashboardContent" class="box-area">
                    <div class="header header-bg">
                        <h2>Dashboard</h2>
                        <a href="../index.php" class="btn-header">Logout</a>
                    </div>
                    <div class="cards-container">
                        <div class="stats-card stats-card-sales">
                            <div class="stats-info">
                                <div class="stats-title">Sales</div>
                                <div class="stats-value" id="totalSales">₱0.00</div>
                            </div>
                            <div class="stats-icon icon-sales-bg">
                                <i class="fa-solid fa-money-bill-trend-up"></i>
                            </div>
                        </div>
                        <div class="stats-card stats-card-profit">
                            <div class="stats-info">
                                <div class="stats-title">Profit</div>
                                <div class="stats-value" id="totalProfit">₱0.00</div>
                            </div>
                            <div class="stats-icon icon-profit-bg">
                              <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                        </div>
                        <div class="stats-card stats-card-products">
                            <div class="stats-info">
                                <div class="stats-title">Products</div>
                                <div class="stats-value" id="totalProducts">0</div>
                            </div>
                            <div class="stats-icon icon-products-bg">
                                <i class="fa-solid fa-boxes-stacked"></i>
                            </div>
                        </div>
                        <div class="stats-card stats-card-purchases">
                            <div class="stats-info">
                                <div class="stats-title">Purchase</div>
                                <div class="stats-value" id="totalPurchases">₱0.00</div>
                            </div>
                            <div class="stats-icon icon-purchases-bg">
                                <i class="fa-solid fa-money-bill"></i>
                            </div>
                        </div>
                    </div>
                    <div class="table-container">
                        <div class="table-box">
                            <h3>Highest Selling Product</h3>
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Total Sold</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" id="highestSellingProductBody">
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
                        <div class="table-box">
                            <h3>Latest Sales</h3>
                            <table class="content-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body" id="latestSalesBody">
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

                                        if ($result && $result->num_rows > 0) {
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
</div>
    