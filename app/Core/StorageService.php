<?php

namespace App\Core;

use Exception;

class StorageService {
    /**
     * Faz upload de arquivo para Vercel Blob (se configurado) ou armazena localmente na pasta uploads/.
     *
     * @param array $file Array $_FILES['campo']
     * @param string $prefix Prefixo do arquivo (ex: 'prod_', 'cat_')
     * @return string URL pública ou caminho relativo do arquivo
     * @throws Exception
     */
    public static function upload(array $file, string $prefix = 'file_'): string {
        if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Erro no upload do arquivo.");
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            throw new Exception("O arquivo não pode ser maior que 5MB.");
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $fileMimeType = $finfo->file($file['tmp_name']);

        $allowedMimes = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml'
        ];

        if (!in_array($fileMimeType, $allowedMimes)) {
            throw new Exception("Formato de arquivo inválido. Permitidos: JPG, PNG, WEBP e SVG.");
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (empty($extension)) {
            $extension = str_replace('image/', '', $fileMimeType);
            if ($extension === 'jpeg') {
                $extension = 'jpg';
            }
        }

        $filename = $prefix . uniqid('', true) . '.' . $extension;

        // Verifica se o token do Vercel Blob está disponível
        $blobToken = getenv('BLOB_READ_WRITE_TOKEN');

        if (!empty($blobToken)) {
            return self::uploadToVercelBlob($file['tmp_name'], $filename, $fileMimeType, $blobToken);
        }

        // Fallback: Armazenamento local
        return self::uploadLocal($file['tmp_name'], $filename);
    }

    /**
     * Upload via API REST da Vercel Blob
     */
    private static function uploadToVercelBlob(string $tmpPath, string $filename, string $mimeType, string $token): string {
        $fileData = file_get_contents($tmpPath);
        if ($fileData === false) {
            throw new Exception("Falha ao ler arquivo temporário para envio ao Blob.");
        }

        $apiEndpoint = "https://blob.vercel-storage.com/" . rawurlencode($filename);

        $ch = curl_init($apiEndpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$token}",
            "x-content-type: {$mimeType}",
            "x-add-random-suffix: 1",
            "Content-Type: {$mimeType}"
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            $data = json_decode($response, true);
            if (!empty($data['url'])) {
                return $data['url'];
            }
        }

        throw new Exception("Erro no upload para o Vercel Blob (HTTP {$httpCode}): " . ($response ?: $curlError));
    }

    /**
     * Upload no disco local
     */
    private static function uploadLocal(string $tmpPath, string $filename): string {
        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Erro ao criar a pasta de uploads.");
            }
        }

        $destPath = $uploadDir . $filename;
        if (!move_uploaded_file($tmpPath, $destPath)) {
            throw new Exception("Erro ao salvar o arquivo no servidor.");
        }

        return '/uploads/' . $filename;
    }
}

