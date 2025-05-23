<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Password</title>
  <link rel="stylesheet" href="../../../public/css/ProfileManagement/UpdatePassword.css">
</head>
<body>
<div class="container mt-5">
  <h2>Change Password</h2>
  <form>
    <div class="mb-3">
      <label for="currentPassword" class="form-label">Current Password</label>
      <input type="password" class="form-control" id="currentPassword">
    </div>
    <div class="mb-3">
      <label for="newPassword" class="form-label">New Password</label>
      <input type="password" class="form-control" id="newPassword">
    </div>
    <div class="mb-3">
      <label for="confirmPassword" class="form-label">Confirm New Password</label>
      <input type="password" class="form-control" id="confirmPassword">
    </div>
    <button type="submit" class="btn btn-success">Update Password</button>
    <a href="../../../app/views/ProfileManagement/ViewProfile.php" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

