<?php
    include "../db.php";

    $productOptions = [];
    $sqlProducts = "SELECT productID, product_name, selling_price FROM products";
    $resultProducts = $conn->query($sqlProducts);
    if ($resultProducts && $resultProducts->num_rows > 0) {
        while ($row = $resultProducts->fetch_assoc()) {
            $productOptions[] = $row;
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
                <tr>
                    <?php
                        include "../db.php";
                        $sql = "SELECT p.product_name AS 'Product Name', s.quantity, s.totalPrice, s.dateSold FROM sales s JOIN products p ON s.productID = p.productID";
                        $result = $conn->query($sql);
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars(ucfirst($row['Product Name'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['totalPrice']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['dateSold']) . "</td>";
                                echo "<td>
                                        <button>Edit</button>
                                        <button>Delete</button>
                                    </td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tr>
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
                <button type="submit" id="addNewSalesButton">Add New Sales</button>
            </form>
        </div>
    </div>
</body>
<script src="changeView.js"></script>
</html>