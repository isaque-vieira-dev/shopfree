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

    /**
     * Exibe o painel principal do usuário.
     */
    public function index(): void {
        $pageTitle = "Painel de Controle";
        require_once __DIR__ . '/../Views/dashboard/index.php';
    }
}
