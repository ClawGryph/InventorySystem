function initProducts(){

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
    
    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var productNameCell = row.children[1];
            var sellingPriceCell = row.children[3];
            var actionsCell = row.children[5];

            if (btn.textContent === "Edit") {
                // Remove the Delete button
                var deleteBtn = actionsCell.querySelector('button:not(.editBtn):not(.saveBtn)');
                if (deleteBtn) {
                    deleteBtn.remove();
                }

                // Save current values BEFORE replacing with inputs
                var oldProductName = productNameCell.textContent.trim();
                var sellingPrice = sellingPriceCell.textContent.trim();

                // Store oldUsername as a data attribute on the button
                btn.dataset.oldProductName = oldProductName;

                // Replace with input fields
                productNameCell.innerHTML = "<input type='text' value='" + oldProductName + "'>";
                sellingPriceCell.innerHTML = "<input type='number' value='" + sellingPrice + "'>";

                // Change Edit to Save
                btn.textContent = "Save";
                btn.classList.add("saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newProductName = productNameCell.querySelector("input").value;
                var newSellingPrice = sellingPriceCell.querySelector("input").value;
                var oldProductName = btn.dataset.oldProductName;

                // AJAX to update
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "editProductHandler.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        productNameCell.textContent = newProductName;
                        sellingPriceCell.textContent = newSellingPrice;
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
                xhr.send("old_productName=" + encodeURIComponent(oldProductName) +
                         "&productName=" + encodeURIComponent(newProductName) +
                         "&sellingPrice=" + encodeURIComponent(newSellingPrice));
            }
        });
    });




// Delete button functionality

    document.querySelectorAll('.deleteBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm("Are you sure you want to delete this product?")) return;
            var row = btn.closest('tr');
            var productID = row.getAttribute('data-product-id');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteProductHandler.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    row.remove();
                } else {
                    alert("Delete failed!");
                }
            };
            xhr.send("productID=" + encodeURIComponent(productID));
        });
    });
}