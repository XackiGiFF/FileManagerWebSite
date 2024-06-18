<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;
$timestamp = time();

?>

    <meta charset="UTF-8">
    <title><?= isset($pageTitle) ? $pageTitle : 'Файловый менеджер - Легкий способ управления вашими файлами' ?></title>
    <!-- Подключаем внешний CSS файл -->
    <link rel="stylesheet" href="<?= THEME_URL ?>assets/css/header_menu.css?v=<?= $timestamp; ?>">
    <link rel="stylesheet" href="<?= THEME_URL ?>assets/css/main.css?v=<?= $timestamp; ?>">
    <link rel="stylesheet" href="<?= THEME_URL ?>assets/css/buttons.css?v=<?= $timestamp; ?>">
    <link rel="canonical" href="<?= $ogUrlGlobal; ?>"/>

    <meta name="yandex-verification" content="8c3d30cf4b46f584" />
    <meta name="description" content="<?= isset($metaDescription) ? $metaDescription : META_DESCRIPTION ?>">
    <meta name="keywords" content="<?= isset($metaKeywords) ? $metaKeywords : META_KEYWORDS ?>">
    <meta name="author" content="<?= isset($metaAuthor) ? $metaAuthor : META_AUTHOR ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?= isset($metaTitle) ? $metaTitle : META_TITLE ?>">
    <meta property="og:description" content="<?= isset($metaDescription) ? $metaDescription : META_DESCRIPTION ?>">
    <meta property="og:image" content="<?= isset($ogImage) ? $ogImage : OG_IMAGE ?>">
    <meta property="og:url" content="<?= isset($ogUrlGlobal) ? $ogUrlGlobal : OG_URL ?>">
    <meta property="og:type" content="website">