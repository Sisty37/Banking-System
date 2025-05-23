<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Avatar</title>
   <link rel="stylesheet" href="../../../public/css/ProfileManagement/ChangeAvator.css">
</head>
<body>
<div class="container mt-5">
  <h2>Change Avatar</h2>
  <form enctype="multipart/form-data">
    <div class="mb-3">
      <label for="avatarUpload" class="form-label">Upload New Avatar</label>
      <input type="file" class="form-control" id="avatarUpload">
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
    <a href="../../../app/views/ProfileManagement/EditProfile.php" class="btn btn-outline-secondary">Back</a>
  </form>
</div>
<script src="../../../public/js/ProfileManagement.js" ></script>
</body>
</html>

