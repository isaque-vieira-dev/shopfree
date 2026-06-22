<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\ProductController;
use App\Controllers\AddressController;
use App\Controllers\CartController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->get('/contato', [HomeController::class, 'contact']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/sobre', [HomeController::class, 'about']);
$router->get('/categories', [HomeController::class, 'categories']);
$router->get('/categorias', [HomeController::class, 'categories']);
$router->get('/products', [HomeController::class, 'products']);
$router->get('/produtos', [HomeController::class, 'products']);
$router->get('/product', [HomeController::class, 'productDetail']);
$router->get('/produto', [HomeController::class, 'productDetail']);

$router->get('/cart', [CartController::class, 'index']);
$router->get('/carrinho', [CartController::class, 'index']);
$router->post('/cart/add', [CartController::class, 'add']);
$router->post('/cart/update', [CartController::class, 'update']);
$router->post('/cart/remove', [CartController::class, 'remove']);

$router->get('/checkout/payment', [CartController::class, 'paymentScreen']);
$router->post('/checkout/place-order', [CartController::class, 'placeOrder']);
$router->get('/checkout/success', [CartController::class, 'checkoutSuccess']);

$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);

$router->get('/seller', [AuthController::class, 'showSellerRegisterForm']);
$router->post('/seller', [AuthController::class, 'registerSeller']);

$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordForm']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

$router->get('/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/categories', [AdminController::class, 'listCategories']);
$router->get('/admin/categories/create', [AdminController::class, 'showCategoryCreate']);
$router->post('/admin/categories/create', [AdminController::class, 'createCategory']);
$router->get('/admin/categories/edit', [AdminController::class, 'showCategoryEdit']);
$router->post('/admin/categories/edit', [AdminController::class, 'updateCategory']);
$router->get('/admin/categories/delete', [AdminController::class, 'deleteCategory']);

$router->get('/admin/admins', [AdminController::class, 'listAdmins']);
$router->get('/admin/admins/create', [AdminController::class, 'showAdminCreate']);
$router->post('/admin/admins/create', [AdminController::class, 'createAdmin']);
$router->get('/admin/admins/edit', [AdminController::class, 'showAdminEdit']);
$router->post('/admin/admins/edit', [AdminController::class, 'updateAdmin']);
$router->get('/admin/admins/delete', [AdminController::class, 'deleteAdmin']);

$router->get('/seller/products', [ProductController::class, 'listProducts']);
$router->get('/seller/products/create', [ProductController::class, 'showProductCreate']);
$router->post('/seller/products/create', [ProductController::class, 'createProduct']);
$router->get('/seller/products/edit', [ProductController::class, 'showProductEdit']);
$router->post('/seller/products/edit', [ProductController::class, 'updateProduct']);
$router->get('/seller/products/delete', [ProductController::class, 'deleteProduct']);

$router->get('/dashboard/addresses', [AddressController::class, 'listAddresses']);
$router->get('/dashboard/addresses/create', [AddressController::class, 'showAddressCreate']);
$router->post('/dashboard/addresses/create', [AddressController::class, 'createAddress']);
$router->get('/dashboard/addresses/edit', [AddressController::class, 'showAddressEdit']);
$router->post('/dashboard/addresses/edit', [AddressController::class, 'updateAddress']);
$router->get('/dashboard/addresses/delete', [AddressController::class, 'deleteAddress']);

$router->get('/dashboard/orders', [DashboardController::class, 'clientOrders']);

$router->get('/seller/orders', [DashboardController::class, 'sellerOrders']);
$router->post('/seller/orders/update-status', [DashboardController::class, 'updateOrderStatus']);

$router->resolve();
