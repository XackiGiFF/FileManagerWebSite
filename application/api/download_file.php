<?php

// Loading config
global $servername, $username, $password, $dbname, $conn;
include $_SERVER['DOCUMENT_ROOT'] . '/application/config.php';
require_once APPLICATION_PATH . 'core/function.php';

// Проверка, передан ли параметр file
if (isset($_GET['file'])) {
    $fileName = basename($_GET['file']); 

    // Получаем информацию о файле из базы данных, включая хеш пароля
    $stmt = $conn->prepare("SELECT file_name, file_data FROM files WHERE generated_name = ?");
    $stmt->bind_param("s", $fileName);
    $stmt->execute();
    $stmt->store_result();

    // Если есть файл в базе
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($originalFileName, $fileData);
        $stmt->fetch();

        // Получаем хэш пароля из базы данных
        $stmt = $conn->prepare("SELECT password_hash FROM files WHERE generated_name = ?");
        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($passwordHash);
        $stmt->fetch();

        // Если пароль требуется
        if (!is_null($passwordHash) && $passwordHash !== '' && isset($_GET['password'])) {
            $password = $_GET['password'];

            // Проверка пароля
            if (password_verify($password, $passwordHash)) {
                // Файл зашифрован, расшифровываем его
                $decryptedData = decryptFileData($fileData, $password);

                if ($decryptedData === false) {
                    $msg = "Ошибка при расшифровке файла.";
                    send_error($msg);
                    exit;
                }

                $tmpFilePath = tempnam(sys_get_temp_dir(), 'tmpfile_');
                file_put_contents($tmpFilePath, $decryptedData);
            } else {
                $msg = "Неверный пароль.";
                send_error($msg);
                exit;
            }
        } else {
            // Файл не зашифрован или пароль не требуется
            $tmpFilePath = tempnam(sys_get_temp_dir(), 'tmpfile_');
            file_put_contents($tmpFilePath, $fileData);
        }

        // Заголовки для скачивания файла
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($originalFileName) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($tmpFilePath));
        readfile($tmpFilePath);
        
        // Удаление временного файла после скачивания
        unlink($tmpFilePath);

        // Обновляем количество скачиваний
        $stmt = $conn->prepare("UPDATE files SET download_count = download_count + 1 WHERE generated_name = ?");
        $stmt->bind_param("s", $fileName);
        $stmt->execute();

        exit;
    } else {
        $msg = "Файл не найден.";
        send_error($msg);
    }
    
    $stmt->close();
} else {
    echo "Файл не указан.";
}

$conn->close();