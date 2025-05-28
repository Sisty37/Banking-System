<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Role Assignment</title>
  <link rel="stylesheet" href="../../../public/css/RoleBasedAccess/roleBasedAccess.css">
</head>
<body>
  <h2>Role Assignment</h2>
  <table>
    <thead>
      <tr>
        <th>User Name</th>
        <th>Email</th>
        <th>Assigned Role</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>John Doe</td>
        <td>john@example.com</td>
        <td>
          <select>
            <option>Admin</option>
            <option>Editor</option>
            <option>User</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Jane Smith</td>
        <td>jane@example.com</td>
        <td>
          <select>
            <option>Admin</option>
            <option>Editor</option>
            <option>User</option>
          </select>
        </td>
      </tr>
    </tbody>
  </table>
  <button class="save-btn" onclick="saveRoles()">Save Roles</button>
  <script src="../../../public/js/RoleBasedAccess.js"></script>
</body>
</html>
