<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;

if (isset($_SESSION['userId']) && !isset($_SESSION['notification'])) {
    // Проверка авторизации пользователя и отсутствие уведомлений
    header("Location: /cabinet"); // Перенаправление на требуемую страницу
    exit();
}

// Устанавливаем мета-данные для страницы регистрации
$pageTitle = 'Регистрация | ' . META_TITLE;
$metaDescription = 'Присоединяйтесь к нашему сервису для хранения и защиты файлов. Регистрация проста и безопасна!';
$metaKeywords = 'регистрация, новый пользователь, создать аккаунт, защита данных, безопасность файлов, облачное хранилище';
$metaTitle = 'Регистрация | ' . META_TITLE;
$ogImageGlobal = ''; // Установите ссылку на изображение для Open Graph
$ogUrlGlobal = OG_URL . 'register'; // Ссылка на страницу регистрации
?>

<div class="container">
    <div class="register-form">
        <h2>Регистрация пользователя</h2>
        <?php get_snippet('register'); // Обработка передаваемых данных в базу ?>
        <div class='notification'></div>
        <form method="post" action="">
            <div class="register-form-group">
                <label class="register-form-label" for="nickname">Никнейм:</label>
                <input type="text" id="nickname" name="nickname" class="register-form-input" required>
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="fullname">ФИО:</label>
                <input type="text" id="fullname" name="fullname" class="register-form-input" required>
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="phone">Телефон:</label>
                <input type="text" id="phone" name="phone" class="register-form-input" required>
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="vk_link">Ссылка на VK:</label>
                <input type="text" id="vk_link" name="vk_link" class="register-form-input">
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="email">Email:</label>
                <input type="email" id="email" name="email" class="register-form-input" required>
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="working_hours">Сколько часов в месяц готовы работать:</label>
                <input type="int" id="working_hours" name="working_hours" class="register-form-input" required>
            </div>
            <div class="register-form-group">
                <label class="register-form-label" for="password">Пароль:</label>
                <input type="password" id="password" name="password" class="register-form-input" required>
            </div>
            <div class="auth-form-buttons">
                <input type="submit" value="Загеристрироваться" class="register-form-btn"> <?php get_button_log(); ?> <!-- Кнопка для перехода на страницу авторизации -->
            </div>
        </form>
        <?php get_button_back(); ?>
    </div>
</div>