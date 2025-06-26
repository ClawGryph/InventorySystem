<div class="section">
    <div class="box-area">
        <div class="first-page">
            <div class="header">
                <h2>User Management</h2>
                <button id="addUserPage" class="btn-header add-btn"><i class="fa-solid fa-circle-plus"></i>Add User</button>
            </div>
            <div class="table-container">
                <table class="content-table" id="userManagementTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Last Login</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- User Management Body -->
                    <tbody class="table-body" id="userManagementBody">
                        <?php
                            include "../db.php";
                            $sql = "SELECT fullname, username, role, lastLogin FROM users";
                            $result = $conn->query($sql);
                            $no = 1;
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr data-username='" . htmlspecialchars($row['username'], ENT_QUOTES) . "'>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . htmlspecialchars(ucfirst($row['fullname'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td>" . htmlspecialchars(ucfirst($row['role'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['lastLogin']) . "</td>";
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
        <div class="modal-body" id="addUserModal">
            <div class="header">
                <a href="#" data-content="userManagement.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
                <h2>Add User</h2>
            </div>
                
            <form class="form-body" id="addUserForm" action="addUserHandler.php" method="POST">
                <label for="fullname">Name:</label>
                <input type="text" id="fullname" name="fullname" required>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>   
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>             
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button type="submit" class="btn-header add-btn" id="addUserButton"> <i class="fa-solid fa-circle-plus"></i> Add User</button>
            </form>
        </div>
    </div>
</div>
    