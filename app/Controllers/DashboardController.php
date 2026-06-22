<?php

namespace App\Controllers;

class DashboardController {
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index(): void {
        $pageTitle = "Painel de Controle";
        require_once __DIR__ . '/../Views/dashboard/index.php';
    }

    public function clientOrders(): void {
        $roleName = $_SESSION['role_name'] ?? '';
        $roleId = $_SESSION['role_id'] ?? 0;
        if ($roleName !== 'Usuário' && $roleId != 2) {
            header('Location: /dashboard');
            exit;
        }

        $orderModel = new \App\Models\Order();
        $orders = $orderModel->getByUser((int)$_SESSION['user_id']);

        foreach ($orders as &$order) {
            $order['items'] = $orderModel->getItems((int)$order['id']);
        }

        $pageTitle = "Meus Pedidos";
        require_once __DIR__ . '/../Views/dashboard/client/orders/index.php';
    }

    public function sellerOrders(): void {
        $roleName = $_SESSION['role_name'] ?? '';
        $roleId = $_SESSION['role_id'] ?? 0;
        if ($roleName !== 'Vendedor' && $roleId != 3) {
            header('Location: /dashboard');
            exit;
        }

        $orderModel = new \App\Models\Order();
        $orders = $orderModel->getBySeller((int)$_SESSION['user_id']);

        foreach ($orders as &$order) {
            $order['items'] = $orderModel->getItemsBySeller((int)$order['id'], (int)$_SESSION['user_id']);
        }

        $pageTitle = "Pedidos Recebidos";
        require_once __DIR__ . '/../Views/dashboard/seller/orders/index.php';
    }

    public function updateOrderStatus(): void {
        $roleName = $_SESSION['role_name'] ?? '';
        $roleId = $_SESSION['role_id'] ?? 0;
        if ($roleName !== 'Vendedor' && $roleId != 3) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Não autorizado.']);
            exit;
        }

        $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $status = isset($_POST['status']) ? trim($_POST['status']) : '';

        $validStatuses = ['PENDING', 'PAID', 'SHIPPED', 'DELIVERED', 'CANCELLED'];
        if ($orderId <= 0 || !in_array($status, $validStatuses)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
            exit;
        }

        $orderModel = new \App\Models\Order();
        $success = $orderModel->updateStatus($orderId, $status);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => $success]);
        exit;
    }
}
