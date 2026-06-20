<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use Exception;

class ProductController {
    private Product $productModel;
    private Category $categoryModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar se é Vendedor (seller)
        if (!isset($_SESSION['user_id']) || ($_SESSION['role_name'] !== 'Vendedor' && $_SESSION['role_id'] != 3)) {
            $_SESSION['dashboard_error'] = "Acesso negado. Apenas vendedores podem gerenciar produtos.";
            header('Location: /dashboard');
            exit;
        }

        $this->productModel = new Product();
        $this->categoryModel = new Category();
    }

    public function listProducts(): void {
        $pageTitle = "Meus Produtos";
        $products = $this->productModel->allBySeller((int)$_SESSION['user_id']);
        $success = $_SESSION['product_success'] ?? null;
        $error = $_SESSION['product_error'] ?? null;
        unset($_SESSION['product_success'], $_SESSION['product_error']);

        require_once __DIR__ . '/../Views/dashboard/seller/products/index.php';
    }

    public function showProductCreate(): void {
        $pageTitle = "Anunciar Novo Produto";
        $categories = $this->categoryModel->all();
        $error = $_SESSION['product_error'] ?? null;
        unset($_SESSION['product_error']);
        $action = "/seller/products/create";

        require_once __DIR__ . '/../Views/dashboard/seller/products/form.php';
    }

    public function createProduct(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /seller/products');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $price = (float)($_POST['price'] ?? 0.0);
        $stock = (int)($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = trim($_POST['image_path'] ?? '');

        if (empty($name) || $categoryId <= 0 || $price <= 0) {
            $_SESSION['product_error'] = "Nome, categoria e preço válido são obrigatórios.";
            header('Location: /seller/products/create');
            exit;
        }

        try {
            $this->productModel->create([
                'user_id' => $_SESSION['user_id'],
                'category_id' => $categoryId,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image_path' => !empty($imagePath) ? $imagePath : null
            ]);

            $_SESSION['product_success'] = "Produto anunciado com sucesso!";
            header('Location: /seller/products');
            exit;
        } catch (Exception $e) {
            $_SESSION['product_error'] = $e->getMessage();
            header('Location: /seller/products/create');
            exit;
        }
    }

    public function showProductEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $product = $this->productModel->find($id);

        // Validar propriedade do produto
        if (!$product || $product['user_id'] != $_SESSION['user_id']) {
            $_SESSION['product_error'] = "Produto não encontrado.";
            header('Location: /seller/products');
            exit;
        }

        $pageTitle = "Editar Produto";
        $categories = $this->categoryModel->all();
        $error = $_SESSION['product_error'] ?? null;
        unset($_SESSION['product_error']);
        $action = "/seller/products/edit?id=" . $id;

        require_once __DIR__ . '/../Views/dashboard/seller/products/form.php';
    }

    public function updateProduct(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
            header('Location: /seller/products');
            exit;
        }

        $product = $this->productModel->find($id);

        // Validar propriedade do produto
        if (!$product || $product['user_id'] != $_SESSION['user_id']) {
            $_SESSION['product_error'] = "Produto não encontrado ou acesso não autorizado.";
            header('Location: /seller/products');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $price = (float)($_POST['price'] ?? 0.0);
        $stock = (int)($_POST['stock'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $imagePath = trim($_POST['image_path'] ?? '');

        if (empty($name) || $categoryId <= 0 || $price <= 0) {
            $_SESSION['product_error'] = "Nome, categoria e preço válido são obrigatórios.";
            header('Location: /seller/products/edit?id=' . $id);
            exit;
        }

        try {
            $this->productModel->update($id, [
                'user_id' => $_SESSION['user_id'],
                'category_id' => $categoryId,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image_path' => !empty($imagePath) ? $imagePath : null
            ]);

            $_SESSION['product_success'] = "Produto atualizado com sucesso!";
            header('Location: /seller/products');
            exit;
        } catch (Exception $e) {
            $_SESSION['product_error'] = $e->getMessage();
            header('Location: /seller/products/edit?id=' . $id);
            exit;
        }
    }

    public function deleteProduct(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /seller/products');
            exit;
        }

        try {
            $this->productModel->delete($id, (int)$_SESSION['user_id']);
            $_SESSION['product_success'] = "Produto removido com sucesso!";
        } catch (Exception $e) {
            $_SESSION['product_error'] = $e->getMessage();
        }

        header('Location: /seller/products');
        exit;
    }
}
