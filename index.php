<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php
include_once 'application/config.php';
include_once APPLICATION_PATH . 'core/function.php';

// Устанавливаем значения по умолчанию для мета-данных
$pageTitle = META_TITLE;
$metaDescription = META_DESCRIPTION;
$metaKeywords = META_KEYWORDS;
$metaAuthor = META_AUTHOR;
$metaTitle = META_TITLE;
$ogImageGlobal = OG_IMAGE;
$ogUrlGlobal = OG_URL;

ob_start();
?>

<?php get_content(); ?>  
<?php get_footer(); ?>  

<?php
$content = ob_get_clean();
get_header();
echo $content;
?>