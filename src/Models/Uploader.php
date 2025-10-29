<?php

namespace Src\Models;

use Src\Exceptions\Infrastructure\UploadException;

class Uploader{

    public static function uploadImages(array $files, string $dir = "/../../resources/bathrooms/"): array {
        $baseDir = __DIR__ . $dir;

        $imageNames = [];

        foreach ($files['tmp_name'] as $i => $tmpName) {
            // Verifica se o upload foi feito corretamente
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                throw new UploadException("Erro no upload de {$files['name'][$i]}");
            }

            // Verifica o tipo de arquivo
            $type = mime_content_type($tmpName);
            if (!in_array($type, ['image/jpeg', 'image/png', 'image/webp'])) {
                throw new UploadException("Invalid file extension: {$files['name'][$i]}");
            }

            // Cria nome único e move o arquivo
            $info = pathinfo($files['name'][$i]);
            $ext = strtolower($info['extension']);
            $newName = uniqid('img_', true) . '.' . $ext;

            if (move_uploaded_file($tmpName, $baseDir . (string)$newName)) {
                $imageNames[] = $newName;
            } else {
                throw new UploadException("Failed to move the file: {$files['name'][$i]}");
            }
        }
        return $imageNames;
    }

}