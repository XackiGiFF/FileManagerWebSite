<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<div class="container">
    <h1>Связаться с нами</h1>
<?php
// Подключение к базе данных
$conn = get_connection();

// Загрузка списка файлов из базы данных
$result = $conn->query("SELECT generated_name FROM files");

if ($result === false) {
    die("Ошибка при выполнении запроса: " . $conn->error);
}

$files = $result->fetch_all(MYSQLI_ASSOC);
$result->free();

// Закрытие соединения с базой данных
$conn->close();

// Статичные страницы
$pages = [
    '',
    'main',
    'about',
    'contact',
    'upload',
    'download'
];

// Генерация URLs
$base_url = 'http://o91119si.beget.tech';

$urls = [];
foreach ($pages as $page) {
    $urls[] = [
        'loc' => $base_url . '/' . $page,
        'lastmod' => date('Y-m-d'),
        'changefreq' => 'monthly',
        'priority' => '0.8',
    ];
}

foreach ($files as $file) {
    $urls[] = [
        'loc' => $base_url . '/files/' . $file['generated_name'],
        'lastmod' => date('Y-m-d'),
        'changefreq' => 'monthly',
        'priority' => '0.5',
    ];
}

// Генерация XML
$sitemap = new SimpleXMLElement('<urlset/>');
$sitemap->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

foreach ($urls as $url_info) {
    $url = $sitemap->addChild('url');
    $url->addChild('loc', $url_info['loc']);
    $url->addChild('lastmod', $url_info['lastmod']);
    $url->addChild('changefreq', $url_info['changefreq']);
    $url->addChild('priority', $url_info['priority']);
}

// Сохранение файла
$sitemap->asXML('sitemap.xml');

echo 'Карта сайта успешно сгенерирована: <a href="sitemap.xml">sitemap.xml</a>';
?>
</div>