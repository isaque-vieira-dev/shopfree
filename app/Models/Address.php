<?php

namespace App\Models;

use PDO;
use Exception;

class Address {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function allByUser(int $userId): array {
        $stmt = $this->db->prepare("SELECT * FROM address WHERE user_id = :user_id ORDER BY is_default DESC, id DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id, int $userId): ?array {
        $stmt = $this->db->prepare("SELECT * FROM address WHERE id = :id AND user_id = :user_id LIMIT 1");
        $stmt->execute(['id' => $id, 'user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $this->db->beginTransaction();
        try {
            if (!empty($data['is_default'])) {
                $stmt = $this->db->prepare("UPDATE address SET is_default = FALSE WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $data['user_id']]);
            }

            $stmt = $this->db->prepare("
                INSERT INTO address (user_id, street, number, complement, neighborhood, city, state, postal_code, country, is_default) 
                VALUES (:user_id, :street, :number, :complement, :neighborhood, :city, :state, :postal_code, :country, :is_default)
            ");
            
            $stmt->execute([
                'user_id'      => $data['user_id'],
                'street'       => trim($data['street']),
                'number'       => trim($data['number']),
                'complement'   => trim($data['complement'] ?? ''),
                'neighborhood' => trim($data['neighborhood']),
                'city'         => trim($data['city']),
                'state'        => trim($data['state']),
                'postal_code'  => trim($data['postal_code']),
                'country'      => trim($data['country'] ?? 'Brasil'),
                'is_default'   => !empty($data['is_default']) ? 1 : 0
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Erro ao criar endereço: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool {
        $this->db->beginTransaction();
        try {
            if (!empty($data['is_default'])) {
                $stmt = $this->db->prepare("UPDATE address SET is_default = FALSE WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $data['user_id']]);
            }

            $stmt = $this->db->prepare("
                UPDATE address 
                SET street = :street, 
                    number = :number, 
                    complement = :complement, 
                    neighborhood = :neighborhood, 
                    city = :city, 
                    state = :state, 
                    postal_code = :postal_code, 
                    country = :country, 
                    is_default = :is_default 
                WHERE id = :id AND user_id = :user_id
            ");
            
            $stmt->execute([
                'id'           => $id,
                'user_id'      => $data['user_id'],
                'street'       => trim($data['street']),
                'number'       => trim($data['number']),
                'complement'   => trim($data['complement'] ?? ''),
                'neighborhood' => trim($data['neighborhood']),
                'city'         => trim($data['city']),
                'state'        => trim($data['state']),
                'postal_code'  => trim($data['postal_code']),
                'country'      => trim($data['country'] ?? 'Brasil'),
                'is_default'   => !empty($data['is_default']) ? 1 : 0
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Erro ao atualizar endereço: " . $e->getMessage());
        }
    }

    public function delete(int $id, int $userId): bool {
        $stmt = $this->db->prepare("DELETE FROM address WHERE id = :id AND user_id = :user_id");
        try {
            return $stmt->execute(['id' => $id, 'user_id' => $userId]);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir endereço: " . $e->getMessage());
        }
    }
}
