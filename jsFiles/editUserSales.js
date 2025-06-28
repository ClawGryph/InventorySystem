function initUserSales(){
    toggleUserManagementView();

    function toggleUserManagementView() {
        const firstPage = document.querySelector(".first-page");
        const salesModal = document.getElementById("userAddSalesModal");

        // Show modal, hide main table
        document.getElementById("addNewSales").addEventListener("click", function () {
            firstPage.classList.add("hidden");
            salesModal.classList.add("active");
        });

        // Back button
        document.querySelector("#userAddSalesModal a[data-content='userSales.php']").addEventListener("click", function (e) {
            e.preventDefault();
            salesModal.classList.remove("active");
            firstPage.classList.remove("hidden");
        });
    }

    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var salesID = row.getAttribute('data-sales-id');
            var soldProductNameCell = row.children[1];
            var quantityCell = row.children[2];
            var actionsCell = row.children[5];

            if (btn.classList.contains("editBtn")) {

                // Save current values BEFORE replacing with inputs
                var oldSoldProductName = soldProductNameCell.textContent.trim();
                var quantity = quantityCell.textContent.trim();

                // Store oldUsername as a data attribute on the button
                btn.dataset.oldSoldProductName = oldSoldProductName;

                // Replace with input fields
                soldProductNameCell.innerHTML = "<input type='text' value='" + oldSoldProductName + "'>";
                quantityCell.innerHTML = "<input type='number' value='" + quantity + "'>";

                // Change Edit to Save
                btn.innerHTML = "<i class='fa-solid fa-floppy-disk'></i>";
                btn.classList.add("icon", "saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newSoldProductName = soldProductNameCell.querySelector("input").value;
                var newQuantity = quantityCell.querySelector("input").value;
                var oldSoldProductName = btn.dataset.oldSoldProductName;

                // AJAX to update
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "../admin/editSalesHandler.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        soldProductNameCell.textContent = newSoldProductName;
                        quantityCell.textContent = newQuantity;
                        btn.innerHTML = "<i class='fa-solid fa-pen-to-square'></i>";
                        btn.classList.add("editBtn");
                        btn.classList.remove("saveBtn");
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
}