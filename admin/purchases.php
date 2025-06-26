<div class="section">
    <div class="box-area">
        <div class="first-page">
            <div class="header">
                <h2>Purchases</h2>
                <button id="addPurchasePage" class="btn-header add-btn width-btn"><i class="fa-solid fa-circle-plus"></i>Add new purchase</button>
            </div>
            <div class="table-container">
                <table class="content-table" id="purchaseTable">
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
                    <tbody class="table-body" id="purchaseBody">
                        <?php
                            include "../db.php";
                            $sql = "SELECT itemID, purchased_name, SUM(stock) AS 'total_stock', price, dateAdded FROM purchaseditem GROUP BY purchased_name, price ORDER BY purchased_name, price";
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
        <div class="modal-body" id="purchaseModal">
            <div class="header">
                <a href="#" data-content="purchases.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
                <h2>Add Purchase Item</h2>
            </div>
            <form class="form-body" id="addPurchaseForm" action="addPurchasedItemHandler.php" method="POST">
                <label for="name">Item Name:</label>
                <input type="text" id="name" name="name" required>   
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" required>             
                <label for="purchase_price">Purchase Price:</label>
                <input type="number" id="purchase_price" name="purchase_price" required>
                    
                <button type="submit" class="btn-header add-btn width-btn" id="addNewPurchase"><i class="fa-solid fa-circle-plus"></i>Add Purchase</button>
            </form>
        </div>
    </div>
</div>