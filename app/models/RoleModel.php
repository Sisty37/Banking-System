<?php
class RoleModel {
    private $db;
    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=banking_system", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    public function getAllRoles() {
        $query = "SELECT * FROM roles ORDER BY role_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRoleById($roleId) {
        $query = "SELECT * FROM roles WHERE role_id = :roleId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createRole($roleName, $description = '') {
        $query = "SELECT * FROM roles WHERE role_name = :roleName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleName', $roleName);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Role name already exists"];
        }
        $query = "INSERT INTO roles (role_name, description) VALUES (:roleName, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleName', $roleName);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Role created successfully"];
        } else {
            return ["success" => false, "message" => "Failed to create role"];
        }
    }
    public function updateRole($roleId, $roleName, $description = '') {
        $query = "SELECT * FROM roles WHERE role_name = :roleName AND role_id != :roleId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleName', $roleName);
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Role name already exists"];
        }
        $query = "UPDATE roles SET role_name = :roleName, description = :description WHERE role_id = :roleId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleName', $roleName);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':roleId', $roleId);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Role updated successfully"];
        } else {
            return ["success" => false, "message" => "Failed to update role"];
        }
    }
    public function deleteRole($roleId) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM role_permissions WHERE role_id = :roleId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
            $query = "DELETE FROM user_roles WHERE role_id = :roleId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
            $query = "DELETE FROM roles WHERE role_id = :roleId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function getAllPermissions() {
        $query = "SELECT * FROM permissions ORDER BY permission_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPermissionById($permissionId) {
        $query = "SELECT * FROM permissions WHERE permission_id = :permissionId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':permissionId', $permissionId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function createPermission($permissionName, $description = '') {
        $query = "SELECT * FROM permissions WHERE permission_name = :permissionName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':permissionName', $permissionName);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return ["success" => false, "message" => "Permission name already exists"];
        }
        $query = "INSERT INTO permissions (permission_name, description) VALUES (:permissionName, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':permissionName', $permissionName);
        $stmt->bindParam(':description', $description);
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Permission created successfully"];
        } else {
            return ["success" => false, "message" => "Failed to create permission"];
        }
    }
    public function deletePermission($permissionId) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM role_permissions WHERE permission_id = :permissionId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':permissionId', $permissionId);
            $stmt->execute();
            $query = "DELETE FROM permissions WHERE permission_id = :permissionId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':permissionId', $permissionId);
            $stmt->execute();
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function getAllRolePermissions() {
        $query = "SELECT * FROM role_permissions";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRolePermissions($roleId) {
        $query = "SELECT p.* 
                 FROM permissions p
                 JOIN role_permissions rp ON p.permission_id = rp.permission_id
                 WHERE rp.role_id = :roleId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':roleId', $roleId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateRolePermissions($roleId, $permissionIds) {
        $this->db->beginTransaction();
        try {
            $query = "DELETE FROM role_permissions WHERE role_id = :roleId";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':roleId', $roleId);
            $stmt->execute();
            if (!empty($permissionIds)) {
                $query = "INSERT INTO role_permissions (role_id, permission_id) VALUES (:roleId, :permissionId)";
                $stmt = $this->db->prepare($query);
                foreach ($permissionIds as $permissionId) {
                    $stmt->bindParam(':roleId', $roleId);
                    $stmt->bindParam(':permissionId', $permissionId);
                    $stmt->execute();
                }
            }
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function userHasPermission($userId, $permissionName) {
        $query = "SELECT COUNT(*) FROM role_permissions rp
                 JOIN user_roles ur ON rp.role_id = ur.role_id
                 JOIN permissions p ON rp.permission_id = p.permission_id
                 WHERE ur.user_id = :userId AND p.permission_name = :permissionName";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':permissionName', $permissionName);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}
?> 