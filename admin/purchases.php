<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchases</title>
</head>
<body>
    <div>
        <h2>Purchases</h2>
        <button id="addPurchasePage">Add new purchase</button>
        <table id="purchaseTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>In-Stock</th>
                    <th>Buying Price</th>
                    <th>Product Added</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <!-- Purchasement Body -->
            <tbody id="purchaseBody">
                <?php
                    include "../db.php";
                    $sql = "SELECT itemID, purchased_name, SUM(stock) OVER (PARTITION BY purchased_name) AS 'total_stock', price, dateAdded FROM purchaseditem;";
                    $result = $conn->query($sql);
                    $no = 1;
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-purchase-id='" . htmlspecialchars($row['itemID'], ENT_QUOTES) . "'>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars(ucfirst($row['purchased_name'])) . "</td>"; //1
                            echo "<td>" . htmlspecialchars($row['total_stock']) . "</td>"; //2
                            echo "<td>" . htmlspecialchars($row['price']) . "</td>"; //3
                            echo "<td>" . htmlspecialchars($row['dateAdded']) . "</td>";
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
        <div id="purchaseModal" style="opacity: 0;">
            <h3>Add Purchase Item</h3>
            <form id="addPurchaseForm" action="addPurchasedItemHandler.php" method="POST">
                <label for="name">Item Name:</label>
                <input type="text" id="name" name="name" required>   
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>             
                <label for="purchase_price">Purchase Price:</label>
                <input type="number" id="purchase_price" name="purchase_price" required>
                
                <button type="submit" id="addNewPurchase">Add Purchase</button>
            </form>
        </div>
    </div>
</body>
<script src="changeView.js"></script>
<script src="editPurchases.js"></script>
</html>