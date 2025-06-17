document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var salesID = row.getAttribute('data-sales-id');
            var soldProductNameCell = row.children[1];
            var quantityCell = row.children[2];
            var actionsCell = row.children[5];

            if (btn.textContent === "Edit") {
                // Remove the Delete button
                var deleteBtn = actionsCell.querySelector('button:not(.editBtn):not(.saveBtn)');
                if (deleteBtn) {
                    deleteBtn.remove();
                }

                // Save current values BEFORE replacing with inputs
                var oldSoldProductName = soldProductNameCell.textContent.trim();
                var quantity = quantityCell.textContent.trim();

                // Store oldUsername as a data attribute on the button
                btn.dataset.oldSoldProductName = oldSoldProductName;

                // Replace with input fields
                soldProductNameCell.innerHTML = "<input type='text' value='" + oldSoldProductName + "'>";
                quantityCell.innerHTML = "<input type='number' value='" + quantity + "'>";

                // Change Edit to Save
                btn.textContent = "Save";
                btn.classList.add("saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newSoldProductName = soldProductNameCell.querySelector("input").value;
                var newQuantity = quantityCell.querySelector("input").value;
                var oldSoldProductName = btn.dataset.oldSoldProductName;

                // AJAX to update
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "editSalesHandler.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        soldProductNameCell.textContent = newSoldProductName;
                        quantityCell.textContent = newQuantity;
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

                        window.location.href = "sales.php"; // Redirect to sales page after edit
                    } else {
                        alert(xhr.responseText || "Update failed!");
                    }
                };
                xhr.send("old_soldProductName=" + encodeURIComponent(oldSoldProductName) +
                         "&soldProductName=" + encodeURIComponent(newSoldProductName) +
                         "&quantity=" + encodeURIComponent(newQuantity) + 
                         "&salesID=" + encodeURIComponent(salesID));
            }
        });
    });
});



// Delete button functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.deleteBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm("Are you sure you want to delete this user?")) return;
            var row = btn.closest('tr');
            var salesID = row.getAttribute('data-sales-id');
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteSalesHandler.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    row.remove();
                } else {
                    alert("Delete failed!");
                }
            };
            xhr.send("salesID=" + encodeURIComponent(salesID));
        });
    });
});