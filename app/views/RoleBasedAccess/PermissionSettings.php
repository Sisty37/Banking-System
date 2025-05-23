<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Administrator') {
    header("Location: ../UserAuthentication/Login.php");
    exit;
}

$firstName = $_SESSION['first_name'] ?? '';
$lastName = $_SESSION['last_name'] ?? '';
$fullName = $firstName . ' ' . $lastName;

require_once __DIR__ . '/../../models/RoleModel.php';
$roleModel = new RoleModel();

$roles = $roleModel->getAllRoles();
$permissions = $roleModel->getAllPermissions();
$rolePermissions = $roleModel->getAllRolePermissions();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_role':
                $roleName = $_POST['role_name'] ?? '';
                $description = $_POST['description'] ?? '';
                
                if (!empty($roleName)) {
                    $result = $roleModel->createRole($roleName, $description);
                    if ($result['success']) {
                        $message = "Role created successfully.";
                        $messageType = "success";
                        $roles = $roleModel->getAllRoles();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role name is required.";
                    $messageType = "danger";
                }
                break;
                
            case 'update_role':
                $roleId = $_POST['role_id'] ?? '';
                $roleName = $_POST['role_name'] ?? '';
                $description = $_POST['description'] ?? '';
                
                if (!empty($roleId) && !empty($roleName)) {
                    $result = $roleModel->updateRole($roleId, $roleName, $description);
                    if ($result['success']) {
                        $message = "Role updated successfully.";
                        $messageType = "success";
                        $roles = $roleModel->getAllRoles();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role ID and name are required.";
                    $messageType = "danger";
                }
                break;
                
            case 'delete_role':
                $roleId = $_POST['role_id'] ?? '';
                
                if (!empty($roleId)) {
                    if ($roleId <= 6) {
                        $message = "Cannot delete default system roles.";
                        $messageType = "warning";
                    } else {
                        $result = $roleModel->deleteRole($roleId);
                        if ($result) {
                            $message = "Role deleted successfully.";
                            $messageType = "success";
                            $roles = $roleModel->getAllRoles();
                        } else {
                            $message = "Failed to delete role.";
                            $messageType = "danger";
                        }
                    }
                } else {
                    $message = "Role ID is required.";
                    $messageType = "danger";
                }
                break;
                
            case 'update_permissions':
                $roleId = $_POST['role_id'] ?? '';
                $permissionIds = $_POST['permissions'] ?? [];
                
                if (!empty($roleId)) {
                    $result = $roleModel->updateRolePermissions($roleId, $permissionIds);
                    if ($result) {
                        $message = "Permissions updated successfully.";
                        $messageType = "success";
                        $rolePermissions = $roleModel->getAllRolePermissions();
                    } else {
                        $message = "Failed to update permissions.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Role ID is required.";
                    $messageType = "danger";
                }
                break;
                
            case 'add_permission':
                $permissionName = $_POST['permission_name'] ?? '';
                $description = $_POST['description'] ?? '';
                
                if (!empty($permissionName)) {
                    $result = $roleModel->createPermission($permissionName, $description);
                    if ($result['success']) {
                        $message = "Permission created successfully.";
                        $messageType = "success";
                        $permissions = $roleModel->getAllPermissions();
                    } else {
                        $message = $result['message'];
                        $messageType = "danger";
                    }
                } else {
                    $message = "Permission name is required.";
                    $messageType = "danger";
                }
                break;
                
            case 'delete_permission':
                $permissionId = $_POST['permission_id'] ?? '';
                
                if (!empty($permissionId)) {
                    $result = $roleModel->deletePermission($permissionId);
                    if ($result) {
                        $message = "Permission deleted successfully.";
                        $messageType = "success";
                        $permissions = $roleModel->getAllPermissions();
                        $rolePermissions = $roleModel->getAllRolePermissions();
                    } else {
                        $message = "Failed to delete permission.";
                        $messageType = "danger";
                    }
                } else {
                    $message = "Permission ID is required.";
                    $messageType = "danger";
                }
                break;
        }
    }
}

$formattedRolePermissions = [];
foreach ($rolePermissions as $rp) {
    $formattedRolePermissions[$rp['role_id']][] = $rp['permission_id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role & Permission Management - Banking System</title>
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white">Banking System</h4>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/admin_dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../Dashboard/user_management.php">
                                <i class="fas fa-users me-2"></i> User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-white" href="#">
                                <i class="fas fa-user-shield me-2"></i> Roles & Permissions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-exchange-alt me-2"></i> Transaction Log
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-chart-line me-2"></i> System Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">
                                <i class="fas fa-cogs me-2"></i> System Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../notifications/notificationCenter.php">
                                <i class="fas fa-bell me-2"></i> Notifications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../DataExport/exportWizard.php">
                                <i class="fas fa-file-export me-2"></i> Data Export
                            </a>
                        </li>
                        <li class="nav-item mt-5">
                            <a class="nav-link text-white" href="../../controllers/UserAuthentication/Logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Role & Permission Management</h1>
                    <div>
                        <span class="badge bg-danger">Administrator</span>
                        <span class="ms-2">Welcome, <?php echo htmlspecialchars($fullName); ?></span>
                    </div>
                </div>
                <?php if (!empty($message)): ?>
                <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Role Management</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                    <i class="fas fa-plus"></i> Add New Role
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="rolesTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Role Name</th>
                                                <th>Description</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($roles): ?>
                                                <?php foreach ($roles as $role): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($role['role_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($role['role_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($role['description'] ?? ''); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($role['created_at'])); ?></td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-info edit-role" data-bs-toggle="modal" data-bs-target="#editRoleModal" 
                                                                    data-role-id="<?php echo $role['role_id']; ?>"
                                                                    data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>"
                                                                    data-description="<?php echo htmlspecialchars($role['description'] ?? ''); ?>">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-primary manage-permissions" data-bs-toggle="modal" data-bs-target="#managePermissionsModal"
                                                                    data-role-id="<?php echo $role['role_id']; ?>"
                                                                    data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>">
                                                                    <i class="fas fa-key"></i>
                                                                </button>
                                                                <?php if ($role['role_id'] > 6): ?>
                                                                    <button type="button" class="btn btn-danger delete-role" data-bs-toggle="modal" data-bs-target="#deleteRoleModal"
                                                                        data-role-id="<?php echo $role['role_id']; ?>"
                                                                        data-role-name="<?php echo htmlspecialchars($role['role_name']); ?>">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No roles found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Permission Management</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                    <i class="fas fa-plus"></i> Add New Permission
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="permissionsTable" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Permission Name</th>
                                                <th>Description</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($permissions): ?>
                                                <?php foreach ($permissions as $permission): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($permission['permission_id']); ?></td>
                                                        <td><?php echo htmlspecialchars($permission['permission_name']); ?></td>
                                                        <td><?php echo htmlspecialchars($permission['description'] ?? ''); ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($permission['created_at'])); ?></td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button type="button" class="btn btn-danger delete-permission" data-bs-toggle="modal" data-bs-target="#deletePermissionModal"
                                                                    data-permission-id="<?php echo $permission['permission_id']; ?>"
                                                                    data-permission-name="<?php echo htmlspecialchars($permission['permission_name']); ?>">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">No permissions found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_role">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="roleName" name="role_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="roleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="roleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_role">
                        <input type="hidden" name="role_id" id="editRoleId">
                        <div class="mb-3">
                            <label for="editRoleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="editRoleName" name="role_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRoleDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editRoleDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Delete Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the role <span id="deleteRoleName"></span>?</p>
                    <p class="text-danger">This will also remove all permissions associated with this role.</p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="action" value="delete_role">
                        <input type="hidden" name="role_id" id="deleteRoleId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="managePermissionsModal" tabindex="-1" aria-labelledby="managePermissionsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="managePermissionsModalLabel">Manage Permissions for <span id="permissionRoleName"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="update_permissions">
                        <input type="hidden" name="role_id" id="permissionRoleId">
                        <div class="row">
                            <?php if ($permissions): ?>
                                <?php foreach ($permissions as $permission): ?>
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox" 
                                                   name="permissions[]" 
                                                   value="<?php echo $permission['permission_id']; ?>" 
                                                   id="permission<?php echo $permission['permission_id']; ?>">
                                            <label class="form-check-label" for="permission<?php echo $permission['permission_id']; ?>">
                                                <?php echo htmlspecialchars($permission['permission_name']); ?>
                                                <?php if (!empty($permission['description'])): ?>
                                                    <small class="text-muted d-block"><?php echo htmlspecialchars($permission['description']); ?></small>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p class="text-center">No permissions available</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Permissions</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPermissionModalLabel">Add New Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add_permission">
                        <div class="mb-3">
                            <label for="permissionName" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" id="permissionName" name="permission_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="permissionDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="permissionDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deletePermissionModal" tabindex="-1" aria-labelledby="deletePermissionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePermissionModalLabel">Delete Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the permission <span id="deletePermissionName"></span>?</p>
                    <p class="text-danger">This will remove this permission from all roles.</p>
                </div>
                <div class="modal-footer">
                    <form method="post">
                        <input type="hidden" name="action" value="delete_permission">
                        <input type="hidden" name="permission_id" id="deletePermissionId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#rolesTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10
            });
            $('#permissionsTable').DataTable({
                "order": [[0, "asc"]],
                "pageLength": 10
            });
            $('.edit-role').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                const description = $(this).data('description');
                $('#editRoleId').val(roleId);
                $('#editRoleName').val(roleName);
                $('#editRoleDescription').val(description);
            });
            $('.delete-role').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                $('#deleteRoleId').val(roleId);
                $('#deleteRoleName').text(roleName);
            });
            $('.manage-permissions').click(function() {
                const roleId = $(this).data('role-id');
                const roleName = $(this).data('role-name');
                $('#permissionRoleId').val(roleId);
                $('#permissionRoleName').text(roleName);
                $('.permission-checkbox').prop('checked', false);
                const rolePermissions = <?php echo json_encode($formattedRolePermissions); ?>;
                if (rolePermissions[roleId]) {
                    rolePermissions[roleId].forEach(function(permissionId) {
                        $('#permission' + permissionId).prop('checked', true);
                    });
                }
            });
            $('.delete-permission').click(function() {
                const permissionId = $(this).data('permission-id');
                const permissionName = $(this).data('permission-name');
                $('#deletePermissionId').val(permissionId);
                $('#deletePermissionName').text(permissionName);
            });
        });
    </script>
</body>
</html>
