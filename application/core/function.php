<?php

defined('CORE_LOADED') or die('Hack attempt!');

// Определяем базовый URL для текущей страницы
function get_current_page_url($request){
    return parse_url($request, PHP_URL_PATH);
}

// Функция для создания URL для пагинации
function create_pagination_url($base_url, $page){
    return rtrim($base_url, '/') . '/' . $page . '/';
}

function get_content() {
    global $page_section;
    $page = isset($_GET['page']) ? $_GET['page'] : '';
    $page_section = isset($_GET['page_section']) ? $_GET['page_section'] : '';
    
    // По умолчанию отображаем главную страницу с загрузчиком файлов
    if ($page === '') {
        $page = 'main'; // Назовем главную страницу 'main', которую будем отображать по умолчанию
    }
    
    $content = THEME_PAGES_PATH . $page . '.php';
    
    if (!file_exists($content)) {
        // Если файл не существует, показываем страницу 404
        $content = THEME_PAGES_PATH . '404.php';
    }
    include($content);
}

function get_head() {
    include_once(THEME_PATH . 'head.php');
}
function get_header() {
    include_once(THEME_PATH . 'header.php');
}

function get_footer() {
    include_once(THEME_PATH . 'footer.php');
}

function load_theme_function() {
    include_once(THEME_PATH . 'function.php');
}

// Функция шифрования
function encryptFileData($data, $encryptionKey) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $encryptionKey, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

// Функция дешифрования
function decryptFileData($data, $encryptionKey) {
    list($encryptedData, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', $encryptionKey, 0, $iv);
}

// Функция хеширования пароля
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function send_error($msg) {
    echo '<p class="error">' . $msg . '</p>';
}

// функция для отправки файла в VirusTotal и проверки результата
function scanFileWithVirusTotal($fileTmpName, $apiKey) {
    $url = 'https://www.virustotal.com/vtapi/v2/file/scan';
    $file = new CURLFile(realpath($fileTmpName));
    
    $post = array('file' => $file, 'apikey' => $apiKey);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $result = json_decode($response, true);
    return $result['scan_id'];
}

function getReportFromVirusTotal($scanId, $apiKey) {
    $url = 'https://www.virustotal.com/vtapi/v2/file/report';
    $params = array('apikey' => $apiKey, 'resource' => $scanId);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Создаем соединение
// Глобальная переменная для хранения соединения
$conn = null;

// Функция для открытия нового соединения, если текущее закрыто
function get_connection() {
    global $servername, $username, $password, $dbname, $conn;

    // Проверяем состояние соединения
    if ($conn === null || $conn->connect_errno || $conn->thread_id === 0) {
        // Создаем новое соединение
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверяем соединение на наличие ошибок
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    return $conn;
}


$conn = get_connection();

// Проверяем соединение
if ($conn->connect_error) {
    die("Connection error!" . $conn->connect_error);
}

// Загрузка темы
load_theme_function();