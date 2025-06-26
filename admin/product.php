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

<div class="section">
    <div class="box-area">
        <div class="first-page">
            <div class="header">
                <h2>Product Management</h2>
                <button id="newProduct" class="btn-header add-btn width-btn"><i class="fa-solid fa-circle-plus"></i>Add New Product</button>
            </div>
            <div class="table-container">
                <table class="content-table" id="productTable">
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
                    <tbody class="table-body" id="productBody">
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
            <div class="modal-body" id="addProductModal">
                <div class="header">
                    <a href="#" data-content="product.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
                    <h2>Add New Product</h2>
                </div>
                <form class="form-body" id="addProductForm" action="addNewProductHandler.php" method="POST">
                    <label for="name">Name:</label>
                    <input type="text" id="username" name="name" required>   
                    
                    <div id="purchaseDropdowns">
                        <label for="purchase_items">Needed Item:</label>
                        <select name="purchase_items[]">
                            <?php foreach ($purchaseItems as $item): ?>
                                <option value="<?php echo htmlspecialchars($item['itemID']); ?>"><?php echo htmlspecialchars($item['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="icon" id="addDropdownBtn"><i class="fa-solid fa-circle-plus"></i></button>
                    <br><br>
                    <label for="totalBuyingPrice">Total Buying Price <span id="totalPrice">0</span></label>
                    <input type="hidden" id="totalBuyingPriceInput" name="buying_price" value="0">
                    <label for="sellingPrice">Selling Price:</label>
                    <input type="number" id="sellingPrice" name="sellingPrice" required>
                    <button type="submit" class="btn-header add-btn width-btn" id="addProductButton"><i class="fa-solid fa-circle-plus"></i>Add Product</button>
                </form>
            </div>
            <script>
                window.purchasePrices = <?php echo json_encode(array_column($purchaseItems, 'price', 'itemID')); ?>;
            </script>
    </div>
</div>