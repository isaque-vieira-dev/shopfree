<?php

namespace App\Models;

use PDO;
use Exception;

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS password_resets (
                email VARCHAR(150) PRIMARY KEY,
                token VARCHAR(255) NOT NULL,
                expires_at DATETIME NOT NULL
            );
        ");
    }

    public function findByEmail(string $email) {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name 
            FROM user u 
            JOIN role r ON u.role_id = r.id 
            WHERE u.email = :email 
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getClientRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'client' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 2;
    }

    public function getSellerRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'seller' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 3;
    }

    public function create(array $data): int {
        $roleId = $data['role_id'] ?? $this->getClientRoleId();
        
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("
            INSERT INTO user (role_id, name, email, password) 
            VALUES (:role_id, :name, :email, :password)
        ");

        try {
            $stmt->execute([
                'role_id'  => $roleId,
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => $hashedPassword
            ]);
            return (int)$this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Erro ao criar usuário: " . $e->getMessage());
        }
    }

    public function savePasswordResetToken(string $email, string $token, string $expiresAt): void {
        $this->deletePasswordResetToken($email);

        $stmt = $this->db->prepare("
            INSERT INTO password_resets (email, token, expires_at) 
            VALUES (:email, :token, :expires_at)
        ");
        $stmt->execute([
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);
    }

    public function getPasswordResetToken(string $token): ?array {
        $stmt = $this->db->prepare("
            SELECT * FROM password_resets 
            WHERE token = :token AND expires_at > NOW() 
            LIMIT 1
        ");
        $stmt->execute(['token' => $token]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function deletePasswordResetToken(string $email): void {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = :email");
        $stmt->execute(['email' => $email]);
    }

    public function updatePassword(int $userId, string $newPassword): void {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $userId
        ]);
    }

    public function getAdminRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'admin' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 1;
    }

    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT u.*, r.name as role_name 
            FROM user u
            JOIN role r ON u.role_id = r.id
            WHERE u.id = :id 
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function allAdmins(): array {
        $adminRoleId = $this->getAdminRoleId();
        $stmt = $this->db->prepare("SELECT * FROM user WHERE role_id = :role_id ORDER BY name ASC");
        $stmt->execute(['role_id' => $adminRoleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteAdmin(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
        try {
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir administrador: " . $e->getMessage());
        }
    }
}
