function initPurchases(){

    toggleUserManagementView();

    function toggleUserManagementView() {
        const firstPage = document.querySelector(".first-page");
        const purchaseModal = document.getElementById("purchaseModal");

        // Show modal, hide main table
        document.getElementById("addPurchasePage").addEventListener("click", function () {
            firstPage.classList.add("hidden");
            purchaseModal.classList.add("active");
        });

        // Back button
        document.querySelector("#purchaseModal a[data-content='purchases.php']").addEventListener("click", function (e) {
            e.preventDefault();
            purchaseModal.classList.remove("active");
            firstPage.classList.remove("hidden");
        });
    }

    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var itemID = row.getAttribute('data-purchase-id');
            var purchasedNameCell = row.children[1];
            var purchasedPriceCell = row.children[3];
            var stockCell = row.children[2];
            var actionsCell = row.children[5];

            if (btn.classList.contains("editBtn")) {
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
                btn.innerHTML = "<i class='fa-solid fa-floppy-disk'></i>";
                btn.classList.add("icon", "saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newPurchasedName = purchasedNameCell.querySelector("input").value.trim();
                var newStock = stockCell.querySelector("input").value.trim();
                var newPurchasedPrice = purchasedPriceCell.querySelector("input").value.trim();
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
                        btn.innerHTML = "<i class='fa-solid fa-pen-to-square'></i>";
                        btn.classList.add("editBtn");
                        btn.classList.remove("saveBtn");

                        // Restore the Delete button
                        if (!actionsCell.querySelector('.deleteBtn')) {
                            var deleteBtn = document.createElement('button');
                            deleteBtn.type = "button";
                            deleteBtn.classList.add("icon", "deleteBtn", "delete-bg");
                            deleteBtn.innerHTML = "<i class='fa-solid fa-trash'></i>";
                            actionsCell.appendChild(deleteBtn);
                        }
                    } else {
                        alert("Update failed!");
                    }
                };
                xhr.send("itemID=" + encodeURI(itemID) +
                         "&old_purchasedName=" + encodeURIComponent(oldPurchasedName) +
                         "&purchasedName=" + encodeURIComponent(newPurchasedName) +
                         "&stock=" + encodeURIComponent(newStock) +
                         "&purchasedPrice=" + encodeURIComponent(newPurchasedPrice));
            }
        });
    });


document.getElementById("purchaseTable").addEventListener("click", function (e) {
    const deleteBtn = e.target.closest(".deleteBtn");
        if (deleteBtn) {
            if (!confirm("Are you sure you want to delete this Purchased Item?")) return;

            const row = deleteBtn.closest("tr");
            const itemID = row.getAttribute('data-purchase-id');
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "deletePurchaseHandler.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    row.remove();
                } else {
                    alert("Delete failed!");
                }
            };
            xhr.send("itemID=" + encodeURIComponent(itemID));
        }
});
}