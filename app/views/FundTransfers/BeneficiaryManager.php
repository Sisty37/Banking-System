<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beneficiary Manager</title>
  <link rel="stylesheet" href="../../../public/css/FundTransfers/BeneficiaryManager.css" />
</head>
<body>
  <div class="container mt-5">
    <h2 class="text-center mb-4">Beneficiary Manager</h2>
    <div class="card p-4 mb-4">
      <form>
        <div class="mb-3">
          <label for="beneficiaryName" class="form-label">Beneficiary Name</label>
          <input type="text" class="form-control" id="beneficiaryName" required />
        </div>
        <div class="mb-3">
          <label for="beneficiaryAccount" class="form-label">Account Number</label>
          <input type="text" class="form-control" id="beneficiaryAccount" required />
        </div>
        <div class="text-end">
          <button type="submit" class="btn btn-success">Add Beneficiary</button>
        </div>
      </form>
    </div>

    <h5>Saved Beneficiaries</h5>
    <ul class="list-group">
      <li class="list-group-item d-flex justify-content-between align-items-center">
        Jane Doe - 222334455
        <button class="btn btn-sm btn-danger">Remove</button>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center">
        John Smith - 554433221
        <button class="btn btn-sm btn-danger">Remove</button>
      </li>
    </ul>
  </div>
  <script src="../../../public/js/FundTransfers.js"></script>
</body>
</html>

