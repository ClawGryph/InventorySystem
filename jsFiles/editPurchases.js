function initPurchases(){
    document.getElementById('addPurchasePage').addEventListener('click', function() {
        document.getElementById('purchaseModal').style.opacity = 1;
        document.getElementById('purchaseTable').style.opacity = 0;
        document.getElementById('addPurchasePage').style.opacity = 0;
    });

    document.getElementById('addNewPurchase').addEventListener('click', function(event) {
        document.getElementById('purchaseModal').style.opacity = 0;
        document.getElementById('purchaseTable').style.opacity = 1;
    });

    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var purchasedNameCell = row.children[1];
            var purchasedPriceCell = row.children[3];
            var stockCell = row.children[2];
            var actionsCell = row.children[5];

            if (btn.textContent === "Edit") {
                // Remove the Delete button
                var deleteBtn = actionsCell.querySelector('button:not(.editBtn):not(.saveBtn)');
                if (deleteBtn) {
                    deleteBtn.remove();
                }

                // Save current values BEFORE replacing with inputs
                var oldPurchasedName = purchasedNameCell.textContent.trim();
                var stock = stockCell.textContent.trim();
                var purchasedPrice = purchasedPriceCell.textContent.trim();

                // Store oldUsername as a data attribute on the button
                btn.dataset.oldPurchasedName = oldPurchasedName;

                // Replace with input fields
                purchasedNameCell.innerHTML = "<input type='text' value='" + oldPurchasedName + "'>";
                stockCell.innerHTML = "<input type='number' value='" + stock + "'>";
                purchasedPriceCell.innerHTML = "<input type='number' value='" + purchasedPrice + "'>";

                // Change Edit to Save
                btn.textContent = "Save";
                btn.classList.add("saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newPurchasedName = purchasedNameCell.querySelector("input").value;
                var newStock = stockCell.querySelector("input").value;
                var newPurchasedPrice = purchasedPriceCell.querySelector("input").value;
                var oldPurchasedName = btn.dataset.oldPurchasedName;

                // AJAX to update
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "editPurchaseHandler.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        purchasedNameCell.textContent = newPurchasedName;
                        stockCell.textContent = newStock;
                        purchasedPriceCell.textContent = newPurchasedPrice;
                        btn.textContent = "Edit";
                        btn.classList.add("editBtn");
                        btn.classList.remove("saveBtn");

                        // Restore the Delete button
                        if (!actionsCell.querySelector('.deleteBtn')) {
                            var deleteBtn = document.createElement('button');
                            deleteBtn.type = "button";
                            deleteBtn.className = "deleteBtn";
                            deleteBtn.textContent = "Delete";
                            actionsCell.appendChild(deleteBtn);
                        }
                    } else {
                        alert("Update failed!");
                    }
                };
                xhr.send("old_purchasedName=" + encodeURIComponent(oldPurchasedName) +
                         "&purchasedName=" + encodeURIComponent(newPurchasedName) +
                         "&stock=" + encodeURIComponent(newStock) +
                         "&purchasedPrice=" + encodeURIComponent(newPurchasedPrice));
            }
        });
    });



// Delete button functionality
    document.querySelectorAll('.deleteBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm("Are you sure you want to delete this product?")) return;
            var row = btn.closest('tr');
            var itemID = row.getAttribute('data-purchase-id');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deletePurchaseHandler.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    row.remove();
                } else {
                    alert("Delete failed!");
                }
            };
            xhr.send("itemID=" + encodeURIComponent(itemID));
        });
    });
}