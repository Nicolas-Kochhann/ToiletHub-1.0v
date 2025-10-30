<?php

namespace Src\Models;

use Src\Exceptions\Infrastructure\UploadException;

class Uploader{

    public static function uploadImages(array $files, string $dir = "/../../resources/bathrooms/"): array {
        $baseDir = __DIR__ . $dir;

        $imageNames = [];

        foreach ($files['tmp_name'] as $i => $tmpName) {
            // Verify if have a upload error
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                throw new UploadException("Failed to upload: {$files['name'][$i]}");
            }

            // Verify the archive type
            $type = mime_content_type($tmpName);
            if (!in_array($type, ['image/jpeg', 'image/png', 'image/webp'])) {
                throw new UploadException("Invalid file extension: {$files['name'][$i]}");
            }

            // Create a unique name and move the file.
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

    public static function deleteImages(array $files): void {

        $dir = __DIR__ . "/../../resources/bathrooms/";

        foreach ($files as $file) {
            
            $filePath = $dir . (string)$file;

            // Delete the image
            if (is_file($filePath)) {
                unlink($filePath);
            }

        }
    }

    public static function uploadImage(array $file, string $dir = "/../../resources/users/"){
        $baseDir = __DIR__.$dir;

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new UploadException("Failed to upload: {$file['name']}");
        }

        $type = mime_content_type($file['tmp_name']);
        if (!in_array($type, ['image/jpeg', 'image/png', 'image/webp'])) {
            throw new UploadException("Invalid file type: {$file['name']}");
        }

        $info = pathinfo($file['name']);
        $ext = strtolower($info['extension']);
        $newName = uniqid('img_', true) . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $baseDir . $newName)) {
            throw new UploadException("Failed to move the file: {$file['name']}");
        }

        return $newName;
    }

    public static function deleteImage(string $file){
        $dir = __DIR__ . "/../../resources/users/";
        
        $filePath = $dir . (string)$file;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

}