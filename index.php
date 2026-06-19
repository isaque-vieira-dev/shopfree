<?php

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

$router = new Router();

// Definir Rotas do MVC
$router->get('/', [HomeController::class, 'index']);
$router->get('/contact', [HomeController::class, 'contact']);
$router->get('/contato', [HomeController::class, 'contact']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/sobre', [HomeController::class, 'about']);

// Resolver Rota Atual
$router->resolve();
