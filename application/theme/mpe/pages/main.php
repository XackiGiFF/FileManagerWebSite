<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;

// Переопределение мета-данных для страницы "О нас"
$pageTitle = 'Главная | ' . META_TITLE;
$metaDescription = META_DESCRIPTION;
$metaKeywords = META_KEYWORDS;
$metaTitle = 'Главная | ' . META_TITLE;
$ogUrlGlobal = OG_URL;
?>
<div class="container">
        <h1>Файловый менеджер</h1>
        <h3>Главная</h3>
        <?php get_upload_btn(); ?>
        <?php //get_snippet('upload_manager_file_form'); // Включаем вывод формы менеджера ?>
        <?php get_snippet('statistics'); // Включаем статистику ?>
        <?php get_snippet('list_files'); // Включаем список файлов ?>
</div>