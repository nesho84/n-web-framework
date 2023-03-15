<?php

class FileUpload
{
    public const ALLOWED_TYPES = [
        "jpg" => "image/jpg",
        "jpeg" => "image/jpeg",
        "gif" => "image/gif",
        "png" => "image/png",
        "pdf" => "application/pdf",
    ];
    public const MAX_SIZE = 5 * 1024 * 1024; // 5 MB in bytes

    public static function upload(array $file, string $targetDir): array
    {
        $validated = true;
        $uploadError = '';

        // Check if the file was uploaded successfully
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $validated = false;
            $uploadError .= 'Error uploading file: ' . $file['error'];
        }

        // Check if the file type is allowed
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (!array_key_exists($fileExtension, self::ALLOWED_TYPES)) {
            $validated = false;
            $uploadError .= 'Invalid file format. Allowed file formats are: ' . implode(', ', array_keys(self::ALLOWED_TYPES));
        }

        // Check if the file size is within the allowed limit
        if ($file['size'] > self::MAX_SIZE) {
            $validated = false;
            $uploadError .= 'File size exceeds the maximum allowed size of ' . self::MAX_SIZE . ' bytes';
        }

        // Verify the file's MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
        if (!in_array($mimeType, array_values(self::ALLOWED_TYPES))) {
            $validated = false;
            $uploadError .= "Invalid file type: {$file['type']}";
        }

        // Generate a unique file name
        $fileName = uniqid() . '_' . $file['name'];
        // Set the target directory
        $targetPath = UPLOAD_PATH . '/' . $targetDir . '/' . $fileName;

        if ($validated === true) {
            // Create folder if does not exist
            if (!is_dir(UPLOAD_PATH . "/$targetDir")) {
                mkdir(UPLOAD_PATH . "/$targetDir", 0777, true);
            }
            // Move the uploaded file to the target directory
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $validated = false;
                $uploadError .= 'Error moving file to target directory';
            }
        }

        // Return an array with the file path and error message, if any
        return [$uploadError, $targetPath];
    }

    public static function uploadMultiple(array $files, string $targetDir): array
    {
        $results = [];

        foreach ($files as $file) {
            $result = self::upload($file, $targetDir);
            $results[] = $result;
        }

        return $results;
    }

    //------------------------------------------------------------
    public static function removeFiles(string $folder, string|array $file): void
    //------------------------------------------------------------
    {
        $dir = UPLOAD_PATH . "/$folder/";

        foreach ([$file] as $fl) {
            $path = $dir . $fl;
            foreach (glob($dir . '*.*') as $f) {
                if ($f === $path) {
                    @unlink($f);
                }
            }
        }
    }
}
