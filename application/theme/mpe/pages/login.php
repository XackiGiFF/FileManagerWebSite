<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;

// Устанавливаем мета-данные для страницы авторизации
$pageTitle = 'Авторизация | ' . META_TITLE;
$metaDescription = 'Авторизуйтесь, чтобы получить доступ к своим данным и управлять ими с удобным интерфейсом нашего облачного менеджера.';
$metaKeywords = 'авторизация, вход, логин, защищенный вход, облачное хранилище, управление данными';
$metaTitle = 'Авторизация | ' . META_TITLE;
$ogImageGlobal = ''; // Установите ссылку на изображение для Open Graph
$ogUrlGlobal = OG_URL . 'login'; // Ссылка на страницу авторизации
?>

<div class="container">
    <div class="login-form">
        <h2>Авторизация пользователя</h2>
        <div class="notification"></div>
        <form method="post" action="">
            <?php get_snippet('login'); // Обработка данных авторизации ?>
            <div class="login-form-group">
                <label class="login-form-label">Email:</label>
                <input type="email" name="email" class="login-form-input" required>
            </div>
            <div class="login-form-group">
                <label class="login-form-label">Пароль:</label>
                <input type="password" name="password" class="login-form-input" required>
            </div>
            <div class="auth-form-buttons">
                <input type="submit" value="Войти" class="login-form-btn"> <?php get_button_reg(); ?> <!-- Кнопка для перехода на страницу регистрации -->
            </div>
        </form>
        <?php get_button_back(); ?>
    </div>
</div>