<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;

class CartController {
    private Product $productModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->productModel = new Product();
    }

    private function checkAccess(): bool {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $roleId = $_SESSION['role_id'] ?? null;
        $roleName = $_SESSION['role_name'] ?? null;
        return ($roleId == 2 || $roleName === 'Usuário');
    }

    private function jsonResponse(array $data, int $statusCode = 200): void {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    public function index(): void {
        if (!$this->checkAccess()) {
            $_SESSION['login_error'] = "Você precisa entrar como cliente para acessar o carrinho.";
            header('Location: /login');
            exit;
        }

        $pageTitle = "Seu Carrinho";
        $cartItems = $_SESSION['cart'] ?? [];
        
        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $addressModel = new \App\Models\Address();
        $userAddresses = $addressModel->allByUser((int)$_SESSION['user_id']);

        require_once __DIR__ . '/../Views/cart.php';
    }

    public function add(): void {
        if (!$this->checkAccess()) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
                $this->jsonResponse(['success' => false, 'message' => 'Faça login como cliente para adicionar ao carrinho.'], 401);
            }
            $_SESSION['login_error'] = "Você precisa entrar como cliente para adicionar produtos ao carrinho.";
            header('Location: /login');
            exit;
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($productId <= 0 || $quantity <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Produto ou quantidade inválida.'], 400);
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->jsonResponse(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        $availableStock = (int)($product['stock'] ?? 0);
        if ($availableStock <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Produto sem estoque disponível.'], 400);
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $currentQty = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId]['quantity'] : 0;
        $newQty = $currentQty + $quantity;

        if ($newQty > $availableStock) {
            $this->jsonResponse([
                'success' => false, 
                'message' => "Desculpe, estoque insuficiente. Você já possui {$currentQty} no carrinho e o estoque total é {$availableStock}."
            ], 400);
        }

        $_SESSION['cart'][$productId] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => (float)$product['price'],
            'image_path' => $product['image_path'],
            'quantity' => $newQty,
            'max_stock' => $availableStock
        ];

        $cartCount = count($_SESSION['cart']);
        $cartTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $this->jsonResponse([
            'success' => true,
            'message' => 'Produto adicionado com sucesso!',
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'cartItems' => array_values($_SESSION['cart'])
        ]);
    }

    public function update(): void {
        if (!$this->checkAccess()) {
            $this->jsonResponse(['success' => false, 'message' => 'Não autorizado.'], 401);
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($productId <= 0 || $quantity <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Parâmetros inválidos.'], 400);
        }

        if (!isset($_SESSION['cart'][$productId])) {
            $this->jsonResponse(['success' => false, 'message' => 'Produto não está no carrinho.'], 404);
        }

        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->jsonResponse(['success' => false, 'message' => 'Produto não encontrado.'], 404);
        }

        $availableStock = (int)($product['stock'] ?? 0);
        if ($quantity > $availableStock) {
            $this->jsonResponse([
                'success' => false,
                'message' => "Estoque insuficiente. Apenas {$availableStock} unidades disponíveis."
            ], 400);
        }

        $_SESSION['cart'][$productId]['quantity'] = $quantity;

        $itemSubtotal = $_SESSION['cart'][$productId]['price'] * $quantity;
        $cartCount = count($_SESSION['cart']);
        $cartTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $this->jsonResponse([
            'success' => true,
            'message' => 'Quantidade atualizada.',
            'itemSubtotal' => $itemSubtotal,
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'cartItems' => array_values($_SESSION['cart'])
        ]);
    }

    public function remove(): void {
        if (!$this->checkAccess()) {
            $this->jsonResponse(['success' => false, 'message' => 'Não autorizado.'], 401);
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        if ($productId <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'ID do produto inválido.'], 400);
        }

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        $cartCount = count($_SESSION['cart']);
        $cartTotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

        $this->jsonResponse([
            'success' => true,
            'message' => 'Produto removido do carrinho.',
            'cartCount' => $cartCount,
            'cartTotal' => $cartTotal,
            'cartItems' => array_values($_SESSION['cart'])
        ]);
    }

    public function paymentScreen(): void {
        if (!$this->checkAccess()) {
            $_SESSION['login_error'] = "Você precisa entrar como cliente para efetuar o pagamento.";
            header('Location: /login');
            exit;
        }

        $addressId = isset($_GET['address_id']) ? (int)$_GET['address_id'] : 0;
        if ($addressId <= 0) {
            $_SESSION['cart_error'] = "Selecione um endereço válido.";
            header('Location: /cart');
            exit;
        }

        $addressModel = new \App\Models\Address();
        $address = $addressModel->find($addressId, (int)$_SESSION['user_id']);
        if (!$address) {
            $_SESSION['cart_error'] = "Endereço não encontrado.";
            header('Location: /cart');
            exit;
        }

        $cartItems = $_SESSION['cart'] ?? [];
        if (empty($cartItems)) {
            header('Location: /cart');
            exit;
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $pageTitle = "Pagamento do Pedido";
        require_once __DIR__ . '/../Views/checkout/payment.php';
    }

    public function placeOrder(): void {
        if (!$this->checkAccess()) {
            $_SESSION['login_error'] = "Não autorizado.";
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /cart');
            exit;
        }

        $addressId = isset($_POST['address_id']) ? (int)$_POST['address_id'] : 0;
        if ($addressId <= 0) {
            $_SESSION['cart_error'] = "Endereço inválido.";
            header('Location: /cart');
            exit;
        }

        $cartItems = $_SESSION['cart'] ?? [];
        if (empty($cartItems)) {
            $_SESSION['cart_error'] = "O seu carrinho está vazio.";
            header('Location: /cart');
            exit;
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        try {
            $orderModel = new \App\Models\Order();
            $orderId = $orderModel->create([
                'user_id'    => $_SESSION['user_id'],
                'address_id' => $addressId,
                'status'     => 'PAID',
                'total'      => $total
            ], array_values($cartItems));

            $_SESSION['cart'] = [];

            header("Location: /checkout/success?order_id={$orderId}");
            exit;
        } catch (\Exception $e) {
            $_SESSION['cart_error'] = "Erro ao registrar o pedido: " . $e->getMessage();
            header('Location: /cart');
            exit;
        }
    }

    public function checkoutSuccess(): void {
        if (!$this->checkAccess()) {
            header('Location: /');
            exit;
        }

        $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        if ($orderId <= 0) {
            header('Location: /');
            exit;
        }

        $orderModel = new \App\Models\Order();
        $order = $orderModel->find($orderId);
        if (!$order || (int)$order['user_id'] !== (int)$_SESSION['user_id']) {
            header('Location: /');
            exit;
        }

        $orderItems = $orderModel->getItems($orderId);

        $pageTitle = "Pedido Realizado com Sucesso!";
        require_once __DIR__ . '/../Views/checkout/success.php';
    }
}
