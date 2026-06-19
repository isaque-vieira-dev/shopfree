<?php

namespace App\Controllers;

class HomeController {
    public function index(): void {
        // Título e dados da página
        $pageTitle = "Elevate Your Home Aesthetics";
        
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
}
