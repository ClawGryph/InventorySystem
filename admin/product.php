<?php
    include "../db.php";
    $purchaseItems = [];
    $sql = "SELECT itemID, purchased_name, price FROM purchaseditem GROUP BY purchased_name, price";
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
                <tr>
                    <?php
                        include "../db.php";
                        $sql = "SELECT product_name, buying_price, selling_price, dateproductadded FROM products";
                        $result = $conn->query($sql);
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['buying_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['selling_price']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['dateproductadded']) . "</td>";
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
</body>
<script>
var purchasePrices = <?php echo json_encode(array_column($purchaseItems, 'price', 'itemID')); ?>;

function updateTotalPrice() {
    var selects = document.querySelectorAll('#purchaseDropdowns select');
    var total = 0;
    selects.forEach(function(select) {
        var itemId = select.value;
        if (purchasePrices[itemId]) {
            total += parseFloat(purchasePrices[itemId]);
        }
    });
    document.getElementById('totalPrice').textContent = total.toFixed(2);
    document.getElementById('totalBuyingPriceInput').value = total.toFixed(2);
}

// Update total when dropdown changes
document.getElementById('purchaseDropdowns').addEventListener('change', updateTotalPrice);

// Update total when new dropdown is added
document.getElementById('addDropdownBtn').addEventListener('click', function() {
    var dropdownsDiv = document.getElementById('purchaseDropdowns');
    var selects = dropdownsDiv.getElementsByTagName('select');
    if (selects.length > 0) {
        var newSelect = selects[0].cloneNode(true);
        dropdownsDiv.appendChild(document.createElement('br'));
        dropdownsDiv.appendChild(newSelect);
        newSelect.addEventListener('change', updateTotalPrice);
    }
    updateTotalPrice();
});

// Initial total
updateTotalPrice();

document.getElementById('newProduct').addEventListener('click', function() {
    document.getElementById('addProductModal').style.opacity = 1;
    document.getElementById('productTable').style.opacity = 0;
    document.getElementById('newProduct').style.opacity = 0;
});

document.getElementById('addProductButton').addEventListener('click', function(event) {
    document.getElementById('addProductModal').style.opacity = 0;
    document.getElementById('productTable').style.opacity = 1;
    document.getElementById('newProduct').style.opacity = 1;
    
});
</script>
</html>