<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Profile</title>
  <link rel="stylesheet" href="../../../public/css/ProfileManagement/ViewProfile.css">
</head>
<body>
<div class="container mt-5">
  <h2>My Profile</h2>
  <div class="card">
    <div class="card-body d-flex align-items-center">
      <img src="default-avatar.png" alt="Profile Picture" class="rounded-circle me-3" width="80" height="80">
      <div>
        <h5 id="username">John Doe</h5>
        <p>Email: <span id="email">john@example.com</span></p>
        <a href="../../../app/views/ProfileManagement/EditProfile.php" class="btn btn-primary btn-sm">Edit Profile</a>
        <a href="../../../app/views/ProfileManagement/UpdatePassword.php" class="btn btn-warning btn-sm">Change Password</a>
      </div>
    </div>
  </div>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

