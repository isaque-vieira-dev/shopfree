<?php

namespace App\Models;

use PDO;
use Exception;

class Product {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Retorna todos os produtos de um vendedor específico.
     */
    public function allBySeller(int $sellerId): array {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE p.user_id = :seller_id
            ORDER BY p.id DESC
        ");
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca um produto por ID.
     */
    public function find(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM product WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    /**
     * Cria um novo produto.
     */
    public function create(array $data): bool {
        $stmt = $this->db->prepare("
            INSERT INTO product (user_id, category_id, name, description, price, stock, image_path) 
            VALUES (:user_id, :category_id, :name, :description, :price, :stock, :image_path)
        ");
        try {
            return $stmt->execute([
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'name' => trim($data['name']),
                'description' => trim($data['description'] ?? ''),
                'price' => $data['price'],
                'stock' => $data['stock'] ?? 0,
                'image_path' => $data['image_path'] ?? null
            ]);
        } catch (Exception $e) {
            throw new Exception("Erro ao criar produto: " . $e->getMessage());
        }
    }

    /**
     * Atualiza um produto.
     */
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE product 
            SET category_id = :category_id, 
                name = :name, 
                description = :description, 
                price = :price, 
                stock = :stock, 
                image_path = :image_path 
            WHERE id = :id AND user_id = :user_id
        ");
        try {
            return $stmt->execute([
                'id' => $id,
                'user_id' => $data['user_id'],
                'category_id' => $data['category_id'],
                'name' => trim($data['name']),
                'description' => trim($data['description'] ?? ''),
                'price' => $data['price'],
                'stock' => $data['stock'] ?? 0,
                'image_path' => $data['image_path'] ?? null
            ]);
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    /**
     * Exclui um produto.
     */
    public function delete(int $id, int $sellerId): bool {
        $stmt = $this->db->prepare("DELETE FROM product WHERE id = :id AND user_id = :seller_id");
        try {
            return $stmt->execute(['id' => $id, 'seller_id' => $sellerId]);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    /**
     * Retorna produtos de uma categoria específica.
     */
    public function getByCategory(int $categoryId, int $limit = 10): array {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name 
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE p.category_id = :category_id
            ORDER BY p.id DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Filtra e pesquisa produtos por categoria e/ou nome.
     */
    public function search(?int $categoryId = null, ?string $search = null): array {
        $sql = "
            SELECT p.*, c.name as category_name 
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE 1=1
        ";
        $params = [];

        if ($categoryId !== null && $categoryId > 0) {
            $sql .= " AND p.category_id = :category_id";
            $params['category_id'] = $categoryId;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= " AND p.name LIKE :search";
            $params['search'] = '%' . trim($search) . '%';
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
