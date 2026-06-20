<?php

// Iniciar a sessão do PHP para controle de login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Habilitar exibição de erros para desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Carregar configurações do sistema
require_once __DIR__ . '/config.php';

// Autoload simples de classes PSR-4 para evitar dependências imediatas de composer
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

// Inicializar Roteador
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

$router = new Router();

// Definir Rotas do MVC
$router->get('/', [HomeController::class, 'index']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->get('/contato', [HomeController::class, 'contact']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/sobre', [HomeController::class, 'about']);

// Rotas de Autenticação
$router->get('/login', [AuthController::class, 'showLoginForm']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/register', [AuthController::class, 'showRegisterForm']);
$router->post('/register', [AuthController::class, 'register']);

// Rotas de Vendedor (Seller)
$router->get('/seller', [AuthController::class, 'showSellerRegisterForm']);
$router->post('/seller', [AuthController::class, 'registerSeller']);

// Rotas de Recuperação de Senha
$router->get('/forgot-password', [AuthController::class, 'showForgotPasswordForm']);
$router->post('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->get('/reset-password', [AuthController::class, 'showResetPasswordForm']);
$router->post('/reset-password', [AuthController::class, 'resetPassword']);

// Resolver Rota Atual
$router->resolve();
