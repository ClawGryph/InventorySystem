function initUserManagement(){
    toggleUserManagementView();

    function toggleUserManagementView() {
        const firstPage = document.querySelector(".first-page");
        const addUserModal = document.getElementById("addUserModal");

        // Show modal, hide main table
        document.getElementById("addUserPage").addEventListener("click", function () {
            firstPage.classList.add("hidden");
            addUserModal.classList.add("active");
        });

        // Back button
        document.querySelector("#addUserModal a[data-content='userManagement.php']").addEventListener("click", function (e) {
            e.preventDefault();
            addUserModal.classList.remove("active");
            firstPage.classList.remove("hidden");
        });
    }

    
    document.querySelectorAll('.editBtn').forEach(function(btn) {
        btn.addEventListener('click', function handler() {
            var row = btn.closest('tr');
            var fullnameCell = row.children[1];
            var usernameCell = row.children[2];
            var roleCell = row.children[3];
            var actionsCell = row.children[5];

            if (btn.classList.contains("editBtn")) {
                // Remove the Delete button
                var deleteBtn = actionsCell.querySelector('button:not(.editBtn):not(.saveBtn)');
                if (deleteBtn) {
                    deleteBtn.remove();
                }

                // Save current values BEFORE replacing with inputs
                var oldUsername = usernameCell.textContent.trim();
                var fullname = fullnameCell.textContent.trim();
                var role = roleCell.textContent.trim().toLowerCase();

                // Store oldUsername as a data attribute on the button
                btn.dataset.oldUsername = oldUsername;

                // Replace with input fields
                fullnameCell.innerHTML = "<input type='text' value='" + fullname + "'>";
                usernameCell.innerHTML = "<input type='text' value='" + oldUsername + "'>";
                roleCell.innerHTML = "<select><option value='admin'>Admin</option><option value='user'>User</option></select>";
                roleCell.querySelector("select").value = role;

                // Change Edit to Save
                btn.innerHTML = "<i class='fa-solid fa-floppy-disk'></i>";
                btn.classList.add("icon", "saveBtn");
                btn.classList.remove("editBtn");
            } else {
                // On Save
                var newFullname = fullnameCell.querySelector("input").value;
                var newUsername = usernameCell.querySelector("input").value;
                var newRole = roleCell.querySelector("select").value;
                var oldUsername = btn.dataset.oldUsername;

                // AJAX to update
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "editUserHandler.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        fullnameCell.textContent = newFullname;
                        usernameCell.textContent = newUsername;
                        roleCell.textContent = newRole.charAt(0).toUpperCase() + newRole.slice(1);
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
                xhr.send("old_username=" + encodeURIComponent(oldUsername) +
                         "&username=" + encodeURIComponent(newUsername) +
                         "&fullname=" + encodeURIComponent(newFullname) +
                         "&role=" + encodeURIComponent(newRole));
            }
        });
    });

    document.getElementById("userManagementTable").addEventListener("click", function (e) {
        const deleteBtn = e.target.closest(".deleteBtn");
        if (deleteBtn) {
            if (!confirm("Are you sure you want to delete this user?")) return;

            const row = deleteBtn.closest("tr");
            const username = row.querySelector("td:nth-child(3)").textContent.trim(); // assuming username is in 3rd cell

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteUserHandler.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.responseText === "success") {
                    row.remove();
                } else {
                    alert("Delete failed!");
                }
            };
            xhr.send("username=" + encodeURIComponent(username));
        }
    });
}