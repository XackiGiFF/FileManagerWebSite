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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $vk_link = $_POST['vk_link'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $working_hours = $_POST['working_hours'];
    $position = 'Tester'; // Устанавливаем по умолчанию должность 'Tester'
    
    
    $errors = [];

    // Проверка никнейма на уникальность
    $stmt = $conn->prepare("SELECT id FROM users WHERE nickname = ?");
    $stmt->bind_param("s", $nickname);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "<li>Такой ник уже используется.</li>";
    }
    $stmt->close();

    // Проверка email на уникальность
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $errors[] = "<li>Такой email уже используется.</li>";
    }
    $stmt->close();

    // Валидация ФИО (например, только русские буквы и минимум два слова)
    if (!preg_match("/^[А-Яа-яёЁ ]{2,}$/u", $fullname) || count(explode(' ', trim($fullname))) < 2) {
        $errors[] = "<li>Неправильное ФИО.</li>";
    }

    // Валидация телефона (например, формат +7XXXXXXXXXX)
    if (!preg_match("/^\+7\d{10}$/", $phone)) {
        $errors[] = "<li>Неправильный телефон.</li>";
    }

    // Валидация VK link (должен начинаться с "vk.com/")
    if (strpos($vk_link, "vk.com/") === false && strpos($vk_link, "https://vk.com/") === false && strpos($vk_link, "http://vk.com/") === false) {
        $errors[] = "<li>Неправильный VK link.</li>";
    }

    // Валидация количества рабочих часов (например, от 1 до 168)
    if (!is_numeric($working_hours) || $working_hours < 1 || $working_hours > 168) {
        $errors[] = "<li>Неправильное количество часов.</li>";
    }
    $pattern = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*d)(?=.*[W_])[A-Za-zdW_]{8,}$/";
    // Проверка сложности пароля (например, минимум 8 символов, одна цифра, одна буква в верхнем и нижнем регистрах)
if (preg_match($pattern, $password)) {
        $errors[] = "<li>Слишком легкий пароль.</li>";
    }

    // Если есть ошибки, сохраняем их в сессии и перенаправляем пользователя
    if (!empty($errors)) {
        $_SESSION['notification'] = ['error', '<ul>' . implode('', $errors) . '</ul>'];
        header("Location: " . $_SERVER['REQUEST_URI']); // Перенаправляем на страницу регистрации
        exit();
    }

    // Используем подготовленные выражения для безопасного добавления нового пользователя
    $stmt = $conn->prepare("INSERT INTO users (nickname, fullname, phone, vk_link, position, working_hours, email, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nickname, $fullname, $phone, $vk_link, $position, $working_hours, $email, $password);

    if ($stmt->execute()) {
        session_regenerate_id(true); // Генерация нового идентификатора сессии после успешного входа
        $_SESSION['notification'] = ['success', 'Вы успешно зарегистрировались!', 'redirectTo' => '/login'];
        header("Location: " . $_SERVER['REQUEST_URI']); // Перенаправляем на страницу регистрации
        exit;
    } else {
        $_SESSION['notification'] = ['error', $stmt->error ];
        header("Location: " . $_SERVER['REQUEST_URI']); // Перенаправляем на страницу регистрации
        exit;
    }
    
        $stmt->close();
}
$conn->close();
?>