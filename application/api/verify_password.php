<?php
// Loading config
global $servername, $username, $password, $dbname, $conn;
include $_SERVER['DOCUMENT_ROOT'] . '/application/config.php';
require_once APPLICATION_PATH . 'core/function.php';

$response = array('valid' => false);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['file']) && isset($_POST['password'])) {
        $fileName = $_POST['file'];
        $password = $_POST['password'];

        // Получаем хэш пароля из базы данных
        $stmt = $conn->prepare("SELECT password_hash FROM files WHERE generated_name = ?");
        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($storedHash);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $storedHash)) {
            $response['valid'] = true;
        }

        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>