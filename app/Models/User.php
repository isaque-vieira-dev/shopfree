<?php

namespace App\Models;

use PDO;
use Exception;

class User {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        // Garantir que a tabela de recuperação de senha existe
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS password_resets (
                email VARCHAR(150) PRIMARY KEY,
                token VARCHAR(255) NOT NULL,
                expires_at DATETIME NOT NULL
            );
        ");
    }

    /**
     * Encontra um usuário por e-mail.
     * 
     * @param string $email
     * @return array|false
     */
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

    /**
     * Encontra o ID do papel de cliente (client role).
     * 
     * @return int
     */
    public function getClientRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'client' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 2; // Default to 2 if not found, but it should be there
    }

    /**
     * Encontra o ID do papel de vendedor (seller role).
     * 
     * @return int
     */
    public function getSellerRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'seller' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 3; // Default to 3 if not found, but it should be there
    }

    /**
     * Cria um novo usuário.
     * 
     * @param array $data ['name', 'email', 'password', 'role_id']
     * @return int ID do usuário inserido
     * @throws Exception
     */
    public function create(array $data): int {
        // Obter role_id para 'client' se não fornecido
        $roleId = $data['role_id'] ?? $this->getClientRoleId();
        
        // Encriptar a senha
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

    /**
     * Salva um token de recuperação de senha no banco.
     */
    public function savePasswordResetToken(string $email, string $token, string $expiresAt): void {
        // Remove token anterior se existir
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

    /**
     * Busca um token de recuperação ativo e válido.
     */
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

    /**
     * Remove um token de recuperação.
     */
    public function deletePasswordResetToken(string $email): void {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = :email");
        $stmt->execute(['email' => $email]);
    }

    /**
     * Atualiza a senha do usuário.
     */
    public function updatePassword(int $userId, string $newPassword): void {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE id = :id");
        $stmt->execute([
            'password' => $hashedPassword,
            'id' => $userId
        ]);
    }

    /**
     * Encontra o ID do papel de administrador.
     */
    public function getAdminRoleId(): int {
        $stmt = $this->db->prepare("SELECT id FROM role WHERE name = 'admin' LIMIT 1");
        $stmt->execute();
        $role = $stmt->fetch();
        return $role ? (int)$role['id'] : 1;
    }

    /**
     * Encontra um usuário por ID.
     */
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

    /**
     * Retorna todos os administradores.
     */
    public function allAdmins(): array {
        $adminRoleId = $this->getAdminRoleId();
        $stmt = $this->db->prepare("SELECT * FROM user WHERE role_id = :role_id ORDER BY name ASC");
        $stmt->execute(['role_id' => $adminRoleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exclui um administrador.
     */
    public function deleteAdmin(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
        try {
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir administrador: " . $e->getMessage());
        }
    }
}
