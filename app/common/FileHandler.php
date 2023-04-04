<?php

class FileHandler
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
    public static function removeUploadedFiles(string $folder, string|array $file): void
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

    /**
     * Get an array of files in a directory with their filename and file sizes.
     *
     * @param string $directory The directory path to list files from.
     * @return array An array of files with their links, filenames, file sizes, and delete links.
     * @throws Exception If the directory does not exist or cannot be read.
     */
    public static function get_files_in_directory(string $directory): array
    {
        // Verify that the directory exists and is readable
        if (!is_dir($directory) || !is_readable($directory)) {
            throw new InvalidArgumentException("Directory does not exist: $directory");
        }

        $files = array();

        // Loop through each file in the directory
        foreach (scandir($directory) as $file_name) {
            // Ignore "." and ".." entries
            if ($file_name === "." || $file_name === "..") {
                continue;
            }
            // Build the full file path
            $file_path = $directory . DIRECTORY_SEPARATOR . $file_name;
            // Check if the file is a regular file
            if (!is_file($file_path)) {
                continue;
            }
            // Verify that the file is readable
            if (!is_readable($file_path)) {
                continue;
            }
            // Sanitize the file name to prevent HTML injection attacks
            $file_name = htmlspecialchars($file_name);

            // Get the file size in kilobytes
            $file_size = "";
            if (($size = filesize($file_path)) !== false) {
                $file_size = round($size / 1024, 2) . " KB";
            } else {
                $file_size = "N/A";
            }

            //  Get the file creation date and time
            $file_created_at = date("d-m-Y H:i:s", filectime($file_path));

            // // Build the link to the file
            // $file_link = "<a href='" . rawurlencode($file_path) . "'>$file_name</a>";

            // // Build the delete link for the file
            // $delete_link = "<a href='" . ADMURL . "/settings/db_backup_delete/" . rawurlencode($file_path) . "'>Delete</a>";

            // Add the file to the array
            $files[] = array(
                "fileName" => $file_name,
                "fileSize" => $file_size,
                "fileCreatedAt" => $file_created_at,
            );
        }

        return $files;
    }

    //------------------------------------------------------------
    public static function remove_files_from_directory(string $dir, string|array $file): void
    //------------------------------------------------------------
    {
        foreach ([$file] as $fl) {
            $path = $dir . $fl;
            foreach (glob($dir . '*.*') as $f) {
                if ($f === $path) {
                    if (!unlink($f)) {
                        throw new Exception("File can’t be deleted!");
                    }
                }
            }
        }
    }
}
