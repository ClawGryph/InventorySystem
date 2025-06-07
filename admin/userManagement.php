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
        <button id="addUserButton">Add User</button>
        <table id="userManagementTable" style="opacity: 1;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- User Management Body -->
            <tbody id="userManagementBody">
                <tr>
                    <td>1</td>
                    <td>john_doe</td>
                    <td>Admin</td>
                    <td>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Add User Modal -->
        <div id="addUserModal" style="opacity: 0;">
            <h3>Add User</h3>
            <form id="addUserForm">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="role">Role:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>
</body>
<script>
document.getElementById('addUserButton').addEventListener('click', function() {
    document.getElementById('addUserModal').style.opacity = '1';
    document.getElementById('userManagementTable').style.opacity = '0';
});
</script>
</html>