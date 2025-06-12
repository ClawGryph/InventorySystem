<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>
<body>
    <div>
        <h2>User Management</h2>
        <button id="addUserPage" style="opacity: 1;">Add User</button>
        <table id="userManagementTable" style="opacity: 1;">
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
            <tbody id="userManagementBody">
                <tr>
                    <?php
                        include "../db.php";
                        $sql = "SELECT fullname, username, role, lastLogin FROM users";
                        $result = $conn->query($sql);
                        $no = 1;
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars(ucfirst($row['fullname'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                echo "<td>" . htmlspecialchars(ucfirst($row['role'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['lastLogin']) . "</td>";
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
        <div id="addUserModal" style="opacity: 0;">
            <h3>Add User</h3>
            <form id="addUserForm" action="addUserHandler.php" method="POST">
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
                <button type="submit" id="addUserButton">Add User</button>
            </form>
        </div>
    </div>
</body>
<script src="changeView.js"></script>
</html>