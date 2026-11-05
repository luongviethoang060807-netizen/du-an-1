<?php


class VipUpload {

    /**
     * BƯỚC 1: Validate file tạm
     */
    public static function validateTemporary(
        array $file, 
        array $allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'], 
        array $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'],
        int $maxSize = 2097152
    ): bool {
        $errorCode = $file['error'] ?? UPLOAD_ERR_NO_FILE;
        if ($errorCode !== UPLOAD_ERR_OK) {
            throw new Exception("Lỗi hệ thống khi tải file (Code: {$errorCode})");
        }

        $tmpPath = $file['tmp_name'] ?? '';
        if (empty($tmpPath) || !is_uploaded_file($tmpPath)) {
            throw new Exception("File không hợp lệ hoặc không an toàn!");
        }

        // Kiểm tra dung lượng
        if ($file['size'] > $maxSize) {
            throw new Exception("Dung lượng vượt quá giới hạn " . ($maxSize / 1024 / 1024) . "MB");
        }

        // Deep Scan MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMimeType = finfo_file($finfo, $tmpPath);
        finfo_close($finfo);

        if (!in_array($realMimeType, $allowedMimeTypes)) {
            throw new Exception("Định dạng file không được phép (MIME: {$realMimeType})");
        }

        return true;
    }

    /**
     * BƯỚC 2: Lưu file sử dụng PATH_ASSETS_UPLOADS từ config
     */
    public static function confirmAndSave(array $file, string $subFolder = ''): string
    {
        // Sử dụng hằng số PATH_ASSETS_UPLOADS đã định nghĩa trong config
        $uploadDir = rtrim(PATH_ASSETS_UPLOADS, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (!empty($subFolder)) {
            $uploadDir .= trim($subFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
            throw new Exception("Không thể khởi tạo thư mục lưu trữ!");
        }

        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $newFileName = 'cyber_' . bin2hex(random_bytes(6)) . '_' . time() . '.' . $fileExt;
        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception("Không thể di chuyển file đến thư mục đích!");
        }

        return $newFileName;
    }

    /**
     * BƯỚC 3: Xóa file
     */
    public static function delete(string $fileName, string $subFolder = ''): bool
    {
        $filePath = rtrim(PATH_ASSETS_UPLOADS, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        if (!empty($subFolder)) {
            $filePath .= trim($subFolder, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }
        $filePath .= basename($fileName);

        if (file_exists($filePath) && is_file($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}