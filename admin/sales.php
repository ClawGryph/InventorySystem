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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
</head>
<body>
    <div>
        <h2>Sales</h2>
        <button id="addNewSales" style="opacity: 1;">Add Sales</button>
        <table id="salesTable" style="opacity: 1;">
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
            <tbody id="salesBody">
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
                                    <button type='button' class='editBtn'>Edit</button>
                                    <button type='button' class='deleteBtn'>Delete</button>
                                </td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>

        <!-- Add User Modal -->
        <div id="addSalesModal" style="opacity: 0;">
            <h3>Add User</h3>
            <form id="addSalesForm" action="addSalesHandler.php" method="POST">
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
                <button type="submit" id="addNewSalesButton">Add New Sales</button>
            </form>
        </div>
    </div>
    <script>
        // Pass PHP array to JS
        var productStockMap = <?php echo json_encode($productStockMap); ?>;
    </script>
    <script src="../jsFiles/checkingStock.js"></script>
    <script src="../jsFiles/changeView.js"></script>
    <script src="../jsFiles/editSales.js"></script>
    <script src="../jsFiles/displayMessageNotification.js"></script>
</body>
</html>