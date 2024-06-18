<?php
/* Start Block */
// Включить отчет об ошибках

error_reporting(E_ALL);
ini_set('display_errors', 1);
// Увеличиваем лимит памяти
ini_set('memory_limit', '2048M');
/* End Block */

$servername = '';
$username = '';
$password = '';
$dbname = '';

const CORE_LOADED = true;

const THEME_NAME = 'mpe'; // There is name of theme

define('APPLICATION_PATH', $_SERVER['DOCUMENT_ROOT'] . '/application/');
define('PLUGINS_PATH', APPLICATION_PATH . '/plugins/');

define('THEME_PATH', $_SERVER['DOCUMENT_ROOT'] . '/application/theme/' . THEME_NAME . '/');
const THEME_PAGES_PATH = THEME_PATH . 'pages/';
const THEME_SNIPPET_PATH = THEME_PATH . 'snippet/';

const THEME_URL = '/application/theme/' . THEME_NAME . '/';
const THEME_PAGES_URL = THEME_URL . '/pages/';

const YOUR_COMPANY = 'MPE: Coders';
const VIRUS_TOTAL_API_KEY = '';

// SEO Block

const SITE_NAME = 'MPE: Coders';
const META_DESCRIPTION = 'Файловый менеджер - это надежный инструмент для управления вашими файлами. Загружайте, организовывайте и делитесь файлами легко и безопасно.';
const META_KEYWORDS = 'файловый менеджер, управление файлами, делиться файлами, загрузка файлов, организация файлов, безопасность данных';
const META_AUTHOR = 'by XackiGiFF - MPE: Coders';
const META_TITLE = 'Файловый менеджер - Легкий способ управления вашими файлами';

const OG_IMAGE = THEME_URL . 'assets/images/site_image.jpg';
const OG_URL = 'http://o91119si.beget.tech/';


