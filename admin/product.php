<?php
    include "../db.php";
    $purchaseItems = [];
    $sql = "SELECT itemID, purchased_name, price FROM purchaseditem WHERE stock > 0 GROUP BY purchased_name, price";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $purchaseItems[] = [
                'itemID' => $row['itemID'],
                'name' => $row['purchased_name'],
                'price' => $row['price']
            ];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
    <div>
        <h2>Product Management</h2>
        <button id="newProduct" style="opacity: 1;">Add New Product</button>
        <table id="productTable" style="opacity: 1;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Product Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <!-- User Management Body -->
            <tbody id="productBody">
                <?php
                    include "../db.php";
                    $sql = "SELECT productID, product_name, buying_price, selling_price, dateproductadded FROM products";
                    $result = $conn->query($sql);
                    $no = 1;
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-product-id='" . htmlspecialchars($row['productID'], ENT_QUOTES) . "'>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>"; //1
                            echo "<td>" . htmlspecialchars($row['buying_price']) . "</td>"; //2
                            echo "<td>" . htmlspecialchars($row['selling_price']) . "</td>"; //3
                            echo "<td>" . htmlspecialchars($row['dateproductadded']) . "</td>";
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
        <div id="addProductModal" style="opacity: 0;">
            <h3>Add User</h3>
            <form id="addProductForm" action="addNewProductHandler.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="username" name="name" required>   
                
                <div id="purchaseDropdowns">
                    <label for="purchase_items">Purchase Item:</label>
                    <select name="purchase_items[]">
                        <?php foreach ($purchaseItems as $item): ?>
                            <option value="<?php echo htmlspecialchars($item['itemID']); ?>"><?php echo htmlspecialchars($item['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" id="addDropdownBtn">Add Another Purchase Item</button>
                <br><br>
                <label for="totalBuyingPrice">Total Buying Price <span id="totalPrice"></span></label>
                <input type="hidden" id="totalBuyingPriceInput" name="buying_price" value="0">
                <label for="sellingPrice">Selling Price:</label>
                <input type="number" id="sellingPrice" name="sellingPrice" required>
                <button type="submit" id="addProductButton">Add Product</button>
            </form>
        </div>
    </div>
    <script src="../jsFiles/changeView.js"></script>
    <script src="../jsFiles/editProducts.js"></script>
    <script>
        var purchasePrices = <?php echo json_encode(array_column($purchaseItems, 'price', 'itemID')); ?>;
    </script>
    <script src="../jsFiles/updatingTotalPrice.js"></script>
</body>
</html>