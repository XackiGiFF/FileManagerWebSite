<!DOCTYPE html>
<html lang="ru">
<head>
    <?php get_head(); ?>
</head>
<div id="top-nav">
    <div class="logo">
        <a href="/"><?= SITE_NAME ?></a>
    </div>
    <div class="menu-buttons">
        <a href="/">Главная</a>
        <a href="/main">Main</a>
        <a href="/about">About</a>
        <a href="/contact">Contact</a>
        <a href="/upload">Upload</a>
        <a href="/download">Download</a>
    </div>
    <div class="auth-buttons">
        <?php if (isset($_SESSION['userId'])): ?>
            <a href="/cabinet" class="auth-btn login-btn"><?php echo htmlspecialchars($_SESSION['nickname']); ?></a>
            <?php get_button_logout(); ?>
        <?php else: ?>
            <?php get_button_log(); ?>
            <?php get_button_reg(); ?>
        <?php endif; ?>
    </div>
    <div class="hamburger-menu" id="hamburger-button">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<div id="mobile-nav">
    <div class="auth-form-buttons">
        <?php if (isset($_SESSION['userId'])): ?>
            <a href="/cabinet" class="auth-btn login-btn"><?php echo htmlspecialchars($_SESSION['nickname']); ?></a>
            <?php get_button_logout(); ?>
        <?php else: ?>
            <?php get_button_log(); ?>
            <?php get_button_reg(); ?>
        <?php endif; ?>
    </div>
    <a href="/">Главная</a>
    <a href="/main">Main</a>
    <a href="/about">About</a>
    <a href="/contact">Contact</a>
    <a href="/upload">Upload</a>
    <a href="/download">Download</a>
    <span id="close-button">&times;</span> <!-- Кнопка закрытия мобильного меню -->
</div>