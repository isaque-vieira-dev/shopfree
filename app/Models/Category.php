<?php

namespace App\Models;

use PDO;
use Exception;

class Category {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Retorna todas as categorias.
     */
    public function all(): array {
        $stmt = $this->db->query("SELECT * FROM category ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Encontra uma categoria pelo ID.
     */
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM category WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Cria uma nova categoria.
     */
    public function create(string $name, ?string $imagePath = null): bool {
        $stmt = $this->db->prepare("INSERT INTO category (name, image_path) VALUES (:name, :image_path)");
        try {
            return $stmt->execute([
                'name' => trim($name),
                'image_path' => $imagePath
            ]);
        } catch (Exception $e) {
            throw new Exception("Erro ao criar categoria: " . $e->getMessage());
        }
    }

    /**
     * Atualiza uma categoria existente.
     */
    public function update(int $id, string $name, ?string $imagePath = null): bool {
        $stmt = $this->db->prepare("UPDATE category SET name = :name, image_path = :image_path WHERE id = :id");
        try {
            return $stmt->execute([
                'id' => $id,
                'name' => trim($name),
                'image_path' => $imagePath
            ]);
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar categoria: " . $e->getMessage());
        }
    }

    /**
     * Exclui uma categoria.
     */
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM category WHERE id = :id");
        try {
            return $stmt->execute(['id' => $id]);
        } catch (Exception $e) {
            throw new Exception("Não é possível excluir esta categoria pois ela pode estar associada a produtos.");
        }
    }
}
