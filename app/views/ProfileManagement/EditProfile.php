<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link href="../../../public/css/ProfileManagement/EditProfile.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Edit Profile</h2>
  <form>
    <div class="mb-3">
      <label for="fullName" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="fullName" value="John Doe">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email Address</label>
      <input type="email" class="form-control" id="email" value="john@example.com">
    </div>
    <a href="../../../app/views/ProfileManagement/ChangeAvator.php" class="btn btn-secondary">Change Avatar</a>
    <button type="submit" class="btn btn-success">Save Changes</button>
    <a href="../../../app/views/ProfileManagement/ViewProfile.php" class="btn btn-outline-secondary">Cancel</a>
  </form>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

