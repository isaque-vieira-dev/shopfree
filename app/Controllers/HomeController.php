<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController {
    private Category $categoryModel;
    private Product $productModel;

    public function __construct() {
        $this->categoryModel = new Category();
        $this->productModel = new Product();
    }

    public function index(): void {
        $pageTitle = "Tem tudo aqui";
        
        $allCategories = $this->categoryModel->all();
        
        $carousels = [];
        $count = 0;
        foreach ($allCategories as $category) {
            $products = $this->productModel->getByCategory((int)$category['id'], 8);
            if (!empty($products)) {
                $carousels[] = [
                    'category' => $category,
                    'products' => $products
                ];
                $count++;
                if ($count >= 3) {
                    break;
                }
            }
        }
        
        require_once __DIR__ . '/../Views/home.php';
    }

    public function contact(): void {
        $pageTitle = "Contact Us";
        require_once __DIR__ . '/../Views/contact.php';
    }

    public function about(): void {
        $pageTitle = "Sobre Nós";
        require_once __DIR__ . '/../Views/about.php';
    }

    public function categories(): void {
        $pageTitle = "Categorias";
        $allCategories = $this->categoryModel->all();
        require_once __DIR__ . '/../Views/categories.php';
    }

    public function products(): void {
        $pageTitle = "Todos os Produtos";
        
        $categoryId = isset($_GET['category_id']) && (int)$_GET['category_id'] > 0 ? (int)$_GET['category_id'] : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;
        
        $allCategories = $this->categoryModel->all();
        $products = $this->productModel->search($categoryId, $search);
        
        require_once __DIR__ . '/../Views/products.php';
    }

    public function productDetail(): void {
        $id = isset($_GET['id']) && (int)$_GET['id'] > 0 ? (int)$_GET['id'] : null;
        if (!$id) {
            header('Location: /products');
            exit;
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            header('Location: /products');
            exit;
        }

        $category = null;
        if (!empty($product['category_id'])) {
            $category = $this->categoryModel->find((int)$product['category_id']);
        }

        $pageTitle = $product['name'];
        require_once __DIR__ . '/../Views/product.php';
    }
}
