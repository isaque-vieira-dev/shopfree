<?php

namespace App\Models;

use PDO;
use Exception;

class Order {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->migrateDatabase();
    }

    private function migrateDatabase(): void {
        try {
            $this->db->exec("ALTER TABLE orders DROP FOREIGN KEY fk_orders_cart");
        } catch (Exception $e) {}

        try {
            $this->db->exec("ALTER TABLE orders DROP INDEX cart_id");
        } catch (Exception $e) {}

        try {
            $this->db->exec("ALTER TABLE orders ADD CONSTRAINT fk_orders_cart FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE RESTRICT ON UPDATE CASCADE");
        } catch (Exception $e) {}
    }

    public function getOrCreateCart(int $userId): int {
        $stmt = $this->db->prepare("SELECT id FROM cart WHERE user_id = :user_id LIMIT 1");
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return (int)$result['id'];
        }

        $stmt = $this->db->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
        $stmt->execute(['user_id' => $userId]);
        return (int)$this->db->lastInsertId();
    }

    public function create(array $orderData, array $items): int {
        $this->db->beginTransaction();

        try {
            $cartId = $this->getOrCreateCart((int)$orderData['user_id']);

            $stmt = $this->db->prepare("
                INSERT INTO orders (cart_id, user_id, address_id, status, total) 
                VALUES (:cart_id, :user_id, :address_id, :status, :total)
            ");
            
            $stmt->execute([
                'cart_id'    => $cartId,
                'user_id'    => $orderData['user_id'],
                'address_id' => $orderData['address_id'],
                'status'     => $orderData['status'] ?? 'PENDING',
                'total'      => $orderData['total']
            ]);

            $orderId = (int)$this->db->lastInsertId();

            $stmtItem = $this->db->prepare("
                INSERT INTO order_item (order_id, product_id, quantity, unit_price, subtotal) 
                VALUES (:order_id, :product_id, :quantity, :unit_price, :subtotal)
            ");

            $stmtStock = $this->db->prepare("
                UPDATE product SET stock = stock - :quantity WHERE id = :id
            ");

            foreach ($items as $item) {
                $subtotal = $item['price'] * $item['quantity'];
                
                $stmtItem->execute([
                    'order_id'   => $orderId,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'unit_price' => $item['price'],
                    'subtotal'   => $subtotal
                ]);

                $stmtStock->execute([
                    'quantity' => $item['quantity'],
                    'id'       => $item['id']
                ]);
            }

            $this->db->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Falha ao registrar pedido: " . $e->getMessage());
        }
    }

    public function find(int $id): ?array {
        $stmt = $this->db->prepare("
            SELECT o.*, a.street, a.number, a.complement, a.neighborhood, a.city, a.state, a.postal_code
            FROM orders o
            LEFT JOIN address a ON o.address_id = a.id
            WHERE o.id = :id 
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getByUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT o.*, a.street, a.number, a.city, a.state 
            FROM orders o
            LEFT JOIN address a ON o.address_id = a.id
            WHERE o.user_id = :user_id
            ORDER BY o.id DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItems(int $orderId): array {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.image_path 
            FROM order_item oi
            JOIN product p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
            ORDER BY oi.id ASC
        ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBySeller(int $sellerId): array {
        $stmt = $this->db->prepare("
            SELECT DISTINCT o.*, a.street, a.number, a.city, a.state, u.name as client_name
            FROM orders o
            JOIN order_item oi ON o.id = oi.order_id
            JOIN product p ON oi.product_id = p.id
            JOIN user u ON o.user_id = u.id
            LEFT JOIN address a ON o.address_id = a.id
            WHERE p.user_id = :seller_id
            ORDER BY o.id DESC
        ");
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemsBySeller(int $orderId, int $sellerId): array {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.image_path 
            FROM order_item oi
            JOIN product p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id AND p.user_id = :seller_id
            ORDER BY oi.id ASC
        ");
        $stmt->execute([
            'order_id'  => $orderId,
            'seller_id' => $sellerId
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :id");
        return $stmt->execute([
            'id'     => $id,
            'status' => $status
        ]);
    }
}
