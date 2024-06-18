<?php $conn = get_connection(); ?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['userId']) && !isset($_SESSION['notification'])) {
    // Проверка авторизации пользователя и отсутствие уведомлений
    header("Location: /cabinet"); // Перенаправление на требуемую страницу
    exit();
}

$response = ['status' => '', 'message' => '', 'redirectTo' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Используем подготовленные выражения для безопасного получения данных пользователя
    $stmt = $conn->prepare("SELECT id, nickname, fullname, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($userId, $nickname, $fullname, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            session_regenerate_id(true); // Генерация нового идентификатора сессии после успешного входа
            // Устанавливаем переменные сессии
            $_SESSION['userId'] = $userId;
            $_SESSION['nickname'] = $nickname;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['notification'] = ['success', 'Вы успешно вошли в систему!', 'redirectTo' => '/cabinet'];
        } else {
            $_SESSION['notification'] = ['error', 'Неправильный пароль.'];
        }
    } else {
        $_SESSION['notification'] = ['error', 'Пользователь с таким email не найден.'];
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    $stmt->close();
    $conn->close();
    exit();
}
?>