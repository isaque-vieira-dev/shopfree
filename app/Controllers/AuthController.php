<?php

namespace App\Controllers;

use App\Models\User;
use Exception;

class AuthController {
    private User $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    /**
     * Exibe a tela de Login
     */
    public function showLoginForm(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $pageTitle = "Entrar";
        $error = $_SESSION['login_error'] ?? null;
        $success = $_SESSION['register_success'] ?? null;

        // Limpa mensagens após exibição
        unset($_SESSION['login_error']);
        unset($_SESSION['register_success']);

        require_once __DIR__ . '/../Views/auth/login.php';
    }

    /**
     * Processa a autenticação
     */
    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = "Por favor, preencha todos os campos.";
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Login com sucesso, definir variáveis de sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role_id'] = $user['role_id'];

            header('Location: /');
            exit;
        } else {
            $_SESSION['login_error'] = "E-mail ou senha incorretos.";
            header('Location: /login');
            exit;
        }
    }

    /**
     * Finaliza a sessão do usuário
     */
    public function logout(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION = [];
        session_destroy();

        header('Location: /');
        exit;
    }

    /**
     * Exibe a tela de Registro
     */
    public function showRegisterForm(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $pageTitle = "Criar Conta";
        $error = $_SESSION['register_error'] ?? null;
        unset($_SESSION['register_error']);

        require_once __DIR__ . '/../Views/auth/register.php';
    }

    /**
     * Processa a criação de conta
     */
    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['register_error'] = "Todos os campos são obrigatórios.";
            header('Location: /register');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['register_error'] = "Por favor, insira um e-mail válido.";
            header('Location: /register');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['register_error'] = "A senha deve ter pelo menos 6 caracteres.";
            header('Location: /register');
            exit;
        }

        // Verificar se e-mail já existe
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['register_error'] = "Este e-mail já está sendo utilizado.";
            header('Location: /register');
            exit;
        }

        try {
            $userId = $this->userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);

            // Se criado com sucesso, logar automaticamente
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            
            // Buscar informações completas do usuário recém criado para pegar o role_id correto
            $newUser = $this->userModel->findByEmail($email);
            if ($newUser) {
                $_SESSION['role_id'] = $newUser['role_id'];
            }

            $_SESSION['register_success'] = "Conta criada com sucesso!";
            header('Location: /');
            exit;
        } catch (Exception $e) {
            $_SESSION['register_error'] = "Erro ao criar conta: " . $e->getMessage();
            header('Location: /register');
            exit;
        }
    }

    /**
     * Exibe a tela de Registro de Vendedor (Seller)
     */
    public function showSellerRegisterForm(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $pageTitle = "Anuncie seus produtos";
        $error = $_SESSION['seller_error'] ?? null;
        unset($_SESSION['seller_error']);

        require_once __DIR__ . '/../Views/auth/register-seller.php';
    }

    /**
     * Processa o registro de Vendedor (Seller)
     */
    public function registerSeller(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /seller');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['seller_error'] = "Todos os campos são obrigatórios.";
            header('Location: /seller');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['seller_error'] = "Por favor, insira um e-mail válido.";
            header('Location: /seller');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['seller_error'] = "A senha deve ter pelo menos 6 caracteres.";
            header('Location: /seller');
            exit;
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['seller_error'] = "Este e-mail já está sendo utilizado.";
            header('Location: /seller');
            exit;
        }

        try {
            $sellerRoleId = $this->userModel->getSellerRoleId();
            $userId = $this->userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role_id' => $sellerRoleId
            ]);

            // Login automático
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['role_id'] = $sellerRoleId;

            $_SESSION['register_success'] = "Sua conta de vendedor foi criada com sucesso!";
            header('Location: /');
            exit;
        } catch (Exception $e) {
            $_SESSION['seller_error'] = "Erro ao criar conta de vendedor: " . $e->getMessage();
            header('Location: /seller');
            exit;
        }
    }

    /**
     * Exibe o formulário de "Esqueci minha senha"
     */
    public function showForgotPasswordForm(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $pageTitle = "Recuperar Senha";
        $error = $_SESSION['forgot_error'] ?? null;
        $success = $_SESSION['forgot_success'] ?? null;
        $resetLink = $_SESSION['reset_link'] ?? null;

        unset($_SESSION['forgot_error']);
        unset($_SESSION['forgot_success']);
        unset($_SESSION['reset_link']);

        require_once __DIR__ . '/../Views/auth/forgot-password.php';
    }

    /**
     * Processa a solicitação de recuperação de senha
     */
    public function forgotPassword(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /forgot-password');
            exit;
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['forgot_error'] = "Por favor, insira um e-mail válido.";
            header('Location: /forgot-password');
            exit;
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            $_SESSION['forgot_error'] = "Se o e-mail estiver cadastrado, você receberá as instruções.";
            header('Location: /forgot-password');
            exit;
        }

        // Gerar token e expiração (1 hora)
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->userModel->savePasswordResetToken($email, $token, $expiresAt);

        // Exibir link na tela para simulação
        $_SESSION['forgot_success'] = "E-mail de recuperação enviado com sucesso! (Simulado)";
        $_SESSION['reset_link'] = "/reset-password?token=" . $token;

        header('Location: /forgot-password');
        exit;
    }

    /**
     * Exibe a tela de redefinição de senha
     */
    public function showResetPasswordForm(): void {
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $_SESSION['forgot_error'] = "Token inválido ou expirado.";
            header('Location: /forgot-password');
            exit;
        }

        $resetData = $this->userModel->getPasswordResetToken($token);

        if (!$resetData) {
            $_SESSION['forgot_error'] = "Token inválido ou expirado.";
            header('Location: /forgot-password');
            exit;
        }

        $pageTitle = "Redefinir Senha";
        $error = $_SESSION['reset_error'] ?? null;
        unset($_SESSION['reset_error']);

        require_once __DIR__ . '/../Views/auth/reset-password.php';
    }

    /**
     * Processa a redefinição de senha
     */
    public function resetPassword(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /forgot-password');
            exit;
        }

        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($token) || empty($password)) {
            $_SESSION['reset_error'] = "Por favor, preencha todos os campos.";
            header('Location: /reset-password?token=' . urlencode($token));
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['reset_error'] = "A senha deve ter pelo menos 6 caracteres.";
            header('Location: /reset-password?token=' . urlencode($token));
            exit;
        }

        $resetData = $this->userModel->getPasswordResetToken($token);

        if (!$resetData) {
            $_SESSION['forgot_error'] = "Token expirado ou inválido.";
            header('Location: /forgot-password');
            exit;
        }

        $user = $this->userModel->findByEmail($resetData['email']);

        if (!$user) {
            $_SESSION['forgot_error'] = "Usuário não encontrado.";
            header('Location: /forgot-password');
            exit;
        }

        // Atualizar senha e remover token
        $this->userModel->updatePassword($user['id'], $password);
        $this->userModel->deletePasswordResetToken($resetData['email']);

        $_SESSION['register_success'] = "Senha redefinida com sucesso! Por favor, faça login.";
        header('Location: /login');
        exit;
    }
}
