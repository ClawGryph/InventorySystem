<?php
    include "../db.php";

    $productOptions = [];
    $sqlProducts = "SELECT p.productID, p.product_name
        FROM products p
        WHERE NOT EXISTS (
            SELECT 1 FROM product_purchased_item ppi
            JOIN purchaseditem pi ON ppi.itemID = pi.itemID
            WHERE ppi.productID = p.productID AND pi.stock <= 0
        )";
    $resultProducts = $conn->query($sqlProducts);
    if ($resultProducts && $resultProducts->num_rows > 0) {
        while ($row = $resultProducts->fetch_assoc()) {
            $productOptions[] = $row;
        }
    }

    $productStockMap = []; // This will hold the lowest stock per productID

    $sqlStock = "SELECT ppi.productID, MIN(pi.stock) AS lowestStock
        FROM product_purchased_item ppi
        JOIN purchaseditem pi ON ppi.itemID = pi.itemID
        GROUP BY ppi.productID";
    $resultStock = $conn->query($sqlStock);

    if ($resultStock && $resultStock->num_rows > 0) {
        while ($row = $resultStock->fetch_assoc()) {
            $productStockMap[$row['productID']] = $row['lowestStock'];
        }
    }
?>
<div class="section">
    <div class="box-area">
        <div class="first-page">
            <div class="header">
                <h2>Sales</h2>
                <button class="btn-header add-btn" id="addNewSales"><i class="fa-solid fa-circle-plus"></i>Add Sales</button>
            </div>
            <div class="table-container">
                <table class="content-table" id="salesTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- User Management Body -->
                    <tbody class="table-body" id="salesBody">
                        <?php
                            include "../db.php";
                            $sql = "SELECT s.salesID, p.product_name AS 'Product_Name', s.quantity, s.totalPrice, s.dateSold FROM sales s JOIN products p ON s.productID = p.productID";
                            $result = $conn->query($sql);
                            $no = 1;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr data-sales-id='" . htmlspecialchars($row['salesID'], ENT_QUOTES) . "'>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . htmlspecialchars(ucfirst($row['Product_Name'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['totalPrice']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['dateSold']) . "</td>";
                                    echo "<td>
                                            <button type='button' class='icon editBtn edit-bg'><i class='fa-solid fa-pen-to-square'></i></button>
                                            <button type='button' class='icon deleteBtn delete-bg'><i class='fa-solid fa-trash'></i></button>
                                        </td>";
                                    echo "</tr>";
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

            <!-- Add User Modal -->
            <div class="modal-body"  id="addSalesModal">
                <div class="header">
                    <a href="#" data-content="sales.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
                    <h2>Add New Sales</h2>
                </div>
                <form class="form-body" id="addSalesForm" action="addSalesHandler.php" method="POST">
                    <label for="productName">Product Name: </label>
                    <select id="productName" name="productID" required>
                        <option value="">Select a product</option>
                        <?php foreach ($productOptions as $product): ?>
                            <option value="<?php echo htmlspecialchars($product['productID']); ?>">
                                <?php echo htmlspecialchars($product['product_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>   
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantitySold" name="quantity" required>
                    <span id="stockError" style="color:red; display:none;"></span>
                    <input type="hidden" id="availableStock">
                    <button type="submit" class="btn-header add-btn width-btn" id="addNewSalesButton"><i class="fa-solid fa-circle-plus"></i>Add New Sales</button>
                </form>
            </div>
            <script>
                // Pass PHP array to JS
                window.productStockMap = <?php echo json_encode($productStockMap); ?>;
            </script>
    </div>
</div>