<?php
defined('CORE_LOADED') or die('Hack attempt!');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = get_connection();
$userId = $_SESSION['userId'];

// Инициализация переменных значениями по умолчанию
$_SESSION['nickname'] = '';
$_SESSION['fullname'] = '';
$_SESSION['phone'] = '';
$_SESSION['vk_link'] = '';
$_SESSION['email'] = '';
$_SESSION['working_hours'] = 0;

// Получение текущих данных пользователя
$stmt = $conn->prepare("SELECT nickname, fullname, phone, vk_link, email, working_hours FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($nickname, $fullname, $phone, $vk_link, $email, $working_hours);
$stmt->fetch();
$stmt->close();

$_SESSION['nickname'] = $nickname;
$_SESSION['fullname'] = $fullname;
$_SESSION['phone'] = $phone;
$_SESSION['vk_link'] = $vk_link;
$_SESSION['email'] = $email;
$_SESSION['working_hours'] = $working_hours;

?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $vk_link = $_POST['vk_link'];
    $email = $_POST['email'];
    $working_hours = $_POST['working_hours'];

    // Обновление данных пользователя
    $stmt = $conn->prepare("UPDATE users SET nickname = ?, fullname = ?, phone = ?, vk_link = ?, email = ?, working_hours = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $nickname, $fullname, $phone, $vk_link, $email, $working_hours, $userId);

    if ($stmt->execute()) {
        session_regenerate_id(true); // Генерация нового идентификатора сессии после успешного входа
        $_SESSION['notification'] = ['success', 'Данные сохранены успешно!'];
    } else {
        $_SESSION['notification'] = ['error', 'Ошибка при сохранении данных: ' . $stmt->error];
    }

    $stmt->close();
    // Перезагрузка страницы для отображения обновленных данных
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
$conn->close();
?>