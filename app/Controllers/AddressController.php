<?php

namespace App\Controllers;

use App\Models\Address;
use Exception;

class AddressController {
    private Address $addressModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || ($_SESSION['role_name'] !== 'Vendedor' && $_SESSION['role_name'] !== 'Usuário' && $_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 3)) {
            $_SESSION['dashboard_error'] = "Acesso negado. Apenas clientes e vendedores podem gerenciar seus endereços.";
            header('Location: /dashboard');
            exit;
        }

        $this->addressModel = new Address();
    }

    public function listAddresses(): void {
        $pageTitle = "Meus Endereços";
        $addresses = $this->addressModel->allByUser((int)$_SESSION['user_id']);
        $success = $_SESSION['address_success'] ?? null;
        $error = $_SESSION['address_error'] ?? null;
        unset($_SESSION['address_success'], $_SESSION['address_error']);

        require_once __DIR__ . '/../Views/dashboard/shared/addresses/index.php';
    }

    public function showAddressCreate(): void {
        $pageTitle = "Novo Endereço";
        $error = $_SESSION['address_error'] ?? null;
        unset($_SESSION['address_error']);
        $action = "/dashboard/addresses/create";

        require_once __DIR__ . '/../Views/dashboard/shared/addresses/form.php';
    }

    public function createAddress(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/addresses');
            exit;
        }

        $street = trim($_POST['street'] ?? '');
        $number = trim($_POST['number'] ?? '');
        $complement = trim($_POST['complement'] ?? '');
        $neighborhood = trim($_POST['neighborhood'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');
        $country = trim($_POST['country'] ?? 'Brasil');
        $isDefault = isset($_POST['is_default']) ? 1 : 0;

        if (empty($street) || empty($number) || empty($neighborhood) || empty($city) || empty($state) || empty($postalCode)) {
            $_SESSION['address_error'] = "Todos os campos obrigatórios devem ser preenchidos.";
            header('Location: /dashboard/addresses/create');
            exit;
        }

        try {
            $this->addressModel->create([
                'user_id' => $_SESSION['user_id'],
                'street' => $street,
                'number' => $number,
                'complement' => $complement,
                'neighborhood' => $neighborhood,
                'city' => $city,
                'state' => $state,
                'postal_code' => $postalCode,
                'country' => $country,
                'is_default' => $isDefault
            ]);

            $_SESSION['address_success'] = "Endereço cadastrado com sucesso!";
            header('Location: /dashboard/addresses');
            exit;
        } catch (Exception $e) {
            $_SESSION['address_error'] = $e->getMessage();
            header('Location: /dashboard/addresses/create');
            exit;
        }
    }

    public function showAddressEdit(): void {
        $id = (int)($_GET['id'] ?? 0);
        $address = $this->addressModel->find($id, (int)$_SESSION['user_id']);

        if (!$address) {
            $_SESSION['address_error'] = "Endereço não encontrado.";
            header('Location: /dashboard/addresses');
            exit;
        }

        $pageTitle = "Editar Endereço";
        $error = $_SESSION['address_error'] ?? null;
        unset($_SESSION['address_error']);
        $action = "/dashboard/addresses/edit?id=" . $id;

        require_once __DIR__ . '/../Views/dashboard/shared/addresses/form.php';
    }

    public function updateAddress(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
            header('Location: /dashboard/addresses');
            exit;
        }

        $address = $this->addressModel->find($id, (int)$_SESSION['user_id']);
        if (!$address) {
            $_SESSION['address_error'] = "Endereço não encontrado ou acesso negado.";
            header('Location: /dashboard/addresses');
            exit;
        }

        $street = trim($_POST['street'] ?? '');
        $number = trim($_POST['number'] ?? '');
        $complement = trim($_POST['complement'] ?? '');
        $neighborhood = trim($_POST['neighborhood'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $state = trim($_POST['state'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');
        $country = trim($_POST['country'] ?? 'Brasil');
        $isDefault = isset($_POST['is_default']) ? 1 : 0;

        if (empty($street) || empty($number) || empty($neighborhood) || empty($city) || empty($state) || empty($postalCode)) {
            $_SESSION['address_error'] = "Todos os campos obrigatórios devem ser preenchidos.";
            header('Location: /dashboard/addresses/edit?id=' . $id);
            exit;
        }

        try {
            $this->addressModel->update($id, [
                'user_id' => $_SESSION['user_id'],
                'street' => $street,
                'number' => $number,
                'complement' => $complement,
                'neighborhood' => $neighborhood,
                'city' => $city,
                'state' => $state,
                'postal_code' => $postalCode,
                'country' => $country,
                'is_default' => $isDefault
            ]);

            $_SESSION['address_success'] = "Endereço atualizado com sucesso!";
            header('Location: /dashboard/addresses');
            exit;
        } catch (Exception $e) {
            $_SESSION['address_error'] = $e->getMessage();
            header('Location: /dashboard/addresses/edit?id=' . $id);
            exit;
        }
    }

    public function deleteAddress(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /dashboard/addresses');
            exit;
        }

        try {
            $this->addressModel->delete($id, (int)$_SESSION['user_id']);
            $_SESSION['address_success'] = "Endereço excluído com sucesso!";
        } catch (Exception $e) {
            $_SESSION['address_error'] = $e->getMessage();
        }

        header('Location: /dashboard/addresses');
        exit;
    }
}
