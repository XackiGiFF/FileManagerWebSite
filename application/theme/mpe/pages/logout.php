<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
// Очистка всех переменных сессии
$_SESSION = array();

// Уничтожение сессии
session_destroy();

// Регистрация нового идентификатора сессии
session_start();
session_regenerate_id(true);

// Перенаправление на страницу входа или другую страницу
header("Location: login");
exit();
?>