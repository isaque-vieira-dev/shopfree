<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\User;
use Exception;

class AdminController {
    private Category $categoryModel;
    private User $userModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar autenticação e se é Administrador
        if (!isset($_SESSION['user_id']) || ($_SESSION['role_name'] !== 'Administrador' && $_SESSION['role_id'] != 1)) {
            $_SESSION['dashboard_error'] = "Acesso negado. Apenas administradores podem acessar esta área.";
            header('Location: /dashboard');
            exit;
        }

        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    /* ==========================================
       CRUD DE CATEGORIAS
       ========================================== */

    public function listCategories(): void {
        $pageTitle = "Gerenciar Categorias";
        $categories = $this->categoryModel->all();
        $success = $_SESSION['category_success'] ?? null;
        $error = $_SESSION['category_error'] ?? null;
        unset($_SESSION['category_success'], $_SESSION['category_error']);

        require_once __DIR__ . '/../Views/dashboard/admin/categories/index.php';
    }

    public function showCategoryCreate(): void {
        $pageTitle = "Nova Categoria";
        $error = $_SESSION['category_error'] ?? null;
        unset($_SESSION['category_error']);
        $action = "/admin/categories/create";

        require_once __DIR__ . '/../Views/dashboard/admin/categories/form.php';
    }

    public function createCategory(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/categories');
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $_SESSION['category_error'] = "O nome da categoria é obrigatório.";
            header('Location: /admin/categories/create');
            exit;
        }

        try {
            $uploadedPath = $this->handleImageUpload();
            $imagePath = $uploadedPath ?? trim($_POST['image_path'] ?? '');

            $this->categoryModel->create($name, !empty($imagePath) ? $imagePath : null);
            $_SESSION['category_success'] = "Categoria criada com sucesso!";
            header('Location: /admin/categories');
            exit;
        } catch (Exception $e) {
            $_SESSION['category_error'] = $e->getMessage();
            header('Location: /admin/categories/create');
            exit;
        }
    }

    public function showCategoryEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $category = $this->categoryModel->find($id);

        if (!$category) {
            $_SESSION['category_error'] = "Categoria não encontrada.";
            header('Location: /admin/categories');
            exit;
        }

        $pageTitle = "Editar Categoria";
        $error = $_SESSION['category_error'] ?? null;
        unset($_SESSION['category_error']);
        $action = "/admin/categories/edit?id=" . $id;

        require_once __DIR__ . '/../Views/dashboard/admin/categories/form.php';
    }

    public function updateCategory(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
            header('Location: /admin/categories');
            exit;
        }

        $name = trim($_POST['name'] ?? '');

        if (empty($name)) {
            $_SESSION['category_error'] = "O nome da categoria é obrigatório.";
            header('Location: /admin/categories/edit?id=' . $id);
            exit;
        }

        try {
            $uploadedPath = $this->handleImageUpload();
            $imagePath = $uploadedPath ?? trim($_POST['image_path'] ?? '');

            $this->categoryModel->update($id, $name, !empty($imagePath) ? $imagePath : null);
            $_SESSION['category_success'] = "Categoria atualizada com sucesso!";
            header('Location: /admin/categories');
            exit;
        } catch (Exception $e) {
            $_SESSION['category_error'] = $e->getMessage();
            header('Location: /admin/categories/edit?id=' . $id);
            exit;
        }
    }

    public function deleteCategory(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /admin/categories');
            exit;
        }

        try {
            $this->categoryModel->delete($id);
            $_SESSION['category_success'] = "Categoria excluída com sucesso!";
        } catch (Exception $e) {
            $_SESSION['category_error'] = $e->getMessage();
        }

        header('Location: /admin/categories');
        exit;
    }

    /* ==========================================
       CRUD DE ADMINISTRADORES
       ========================================== */

    public function listAdmins(): void {
        $pageTitle = "Gerenciar Administradores";
        $admins = $this->userModel->allAdmins();
        $success = $_SESSION['admin_success'] ?? null;
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_success'], $_SESSION['admin_error']);

        require_once __DIR__ . '/../Views/dashboard/admin/admins/index.php';
    }

    public function showAdminCreate(): void {
        $pageTitle = "Novo Administrador";
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);
        $action = "/admin/admins/create";

        require_once __DIR__ . '/../Views/dashboard/admin/admins/form.php';
    }

    public function createAdmin(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /admin/admins');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['admin_error'] = "Todos os campos são obrigatórios.";
            header('Location: /admin/admins/create');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['admin_error'] = "Por favor, insira um e-mail válido.";
            header('Location: /admin/admins/create');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['admin_error'] = "A senha deve ter pelo menos 6 caracteres.";
            header('Location: /admin/admins/create');
            exit;
        }

        if ($this->userModel->findByEmail($email)) {
            $_SESSION['admin_error'] = "Este e-mail já está sendo utilizado.";
            header('Location: /admin/admins/create');
            exit;
        }

        try {
            $adminRoleId = $this->userModel->getAdminRoleId();
            $this->userModel->create([
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'role_id' => $adminRoleId
            ]);

            $_SESSION['admin_success'] = "Administrador cadastrado com sucesso!";
            header('Location: /admin/admins');
            exit;
        } catch (Exception $e) {
            $_SESSION['admin_error'] = $e->getMessage();
            header('Location: /admin/admins/create');
            exit;
        }
    }

    public function showAdminEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $admin = $this->userModel->findById($id);

        if (!$admin || $admin['role_id'] != $this->userModel->getAdminRoleId()) {
            $_SESSION['admin_error'] = "Administrador não encontrado.";
            header('Location: /admin/admins');
            exit;
        }

        $pageTitle = "Editar Administrador";
        $error = $_SESSION['admin_error'] ?? null;
        unset($_SESSION['admin_error']);
        $action = "/admin/admins/edit?id=" . $id;

        require_once __DIR__ . '/../Views/dashboard/admin/admins/form.php';
    }

    public function updateAdmin(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
            header('Location: /admin/admins');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($name)) {
            $_SESSION['admin_error'] = "O nome é obrigatório.";
            header('Location: /admin/admins/edit?id=' . $id);
            exit;
        }

        try {
            // Atualizar o nome do administrador no banco
            $db = \App\Models\Database::getConnection();
            $stmt = $db->prepare("UPDATE user SET name = :name WHERE id = :id");
            $stmt->execute(['name' => $name, 'id' => $id]);

            // Atualizar a senha se uma nova foi fornecida
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $_SESSION['admin_error'] = "A nova senha deve ter pelo menos 6 caracteres.";
                    header('Location: /admin/admins/edit?id=' . $id);
                    exit;
                }
                $this->userModel->updatePassword($id, $password);
            }

            // Atualizar o nome do usuário logado se for ele mesmo
            if ($id === (int)$_SESSION['user_id']) {
                $_SESSION['user_name'] = $name;
            }

            $_SESSION['admin_success'] = "Administrador atualizado com sucesso!";
            header('Location: /admin/admins');
            exit;
        } catch (Exception $e) {
            $_SESSION['admin_error'] = $e->getMessage();
            header('Location: /admin/admins/edit?id=' . $id);
            exit;
        }
    }

    public function deleteAdmin(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /admin/admins');
            exit;
        }

        // Impedir que o admin logado se exclua
        if ($id === (int)$_SESSION['user_id']) {
            $_SESSION['admin_error'] = "Você não pode excluir a sua própria conta.";
            header('Location: /admin/admins');
            exit;
        }

        try {
            $this->userModel->deleteAdmin($id);
            $_SESSION['admin_success'] = "Administrador excluído com sucesso!";
        } catch (Exception $e) {
            $_SESSION['admin_error'] = $e->getMessage();
        }

        header('Location: /admin/admins');
        exit;
    }

    /**
     * Valida e salva o upload de imagem de uma categoria.
     * Retorna o caminho público do arquivo ou null se não houver upload.
     */
    private function handleImageUpload(): ?string {
        if (!isset($_FILES['image_file']) || $_FILES['image_file']['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        $file = $_FILES['image_file'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro no upload do arquivo (Código " . $file['error'] . ").");
        }

        // Validar tamanho (5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception("O tamanho máximo permitido para imagem é de 5MB.");
        }

        // Validar tipo do arquivo
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!file_exists($file['tmp_name'])) {
            throw new Exception("Arquivo temporário não encontrado.");
        }
        $fileMimeType = mime_content_type($file['tmp_name']);
        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            throw new Exception("Tipo de arquivo inválido. Apenas JPG, PNG, GIF e WEBP são permitidos.");
        }

        // Obter extensão
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = str_replace('image/', '', $fileMimeType);
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }
        }

        // Garantir que a pasta de uploads existe
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Erro ao criar a pasta de uploads.");
            }
        }

        // Gerar nome único e seguro
        $newFilename = uniqid('cat_', true) . '.' . $extension;
        $destPath = $uploadDir . $newFilename;

        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            throw new Exception("Erro ao salvar o arquivo no servidor.");
        }

        return '/uploads/' . $newFilename;
    }
}
