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
        // Título e dados da página
        $pageTitle = "Elevate Your Home Aesthetics";
        
        // Buscar todas as categorias
        $allCategories = $this->categoryModel->all();
        
        // Selecionar as 3 primeiras categorias que contêm produtos
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
        
        // Incluir a view da home
        require_once __DIR__ . '/../Views/home.php';
    }

    public function contact(): void {
        // Título e dados da página de contato
        $pageTitle = "Contact Us";
        
        // Incluir a view de contato
        require_once __DIR__ . '/../Views/contact.php';
    }

    public function about(): void {
        // Título e dados da página sobre nós
        $pageTitle = "Sobre Nós";
        
        // Incluir a view de sobre nós
        require_once __DIR__ . '/../Views/about.php';
    }

    public function categories(): void {
        // Título e dados da página de categorias
        $pageTitle = "Categorias";
        
        // Buscar todas as categorias
        $allCategories = $this->categoryModel->all();
        
        // Incluir a view de categorias
        require_once __DIR__ . '/../Views/categories.php';
    }

    public function products(): void {
        $pageTitle = "Todos os Produtos";
        
        $categoryId = isset($_GET['category_id']) && (int)$_GET['category_id'] > 0 ? (int)$_GET['category_id'] : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;
        
        // Buscar todas as categorias para o filtro
        $allCategories = $this->categoryModel->all();
        
        // Buscar produtos filtrados
        $products = $this->productModel->search($categoryId, $search);
        
        // Incluir a view de produtos
        require_once __DIR__ . '/../Views/products.php';
    }
}
