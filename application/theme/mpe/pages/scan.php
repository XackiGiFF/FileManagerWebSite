<?php
// URL для получения аудиозаписей
$api_url = "https://api.vk.com/method/audio.get?owner_id=192212848&access_token=vk1.a.mt1whdrihoDKeyBD565Vu_xrxRrWRsHYRzKBRYI_aOxj6P8yHFDpYvveJTasGT8cxKSnQ1F_fr02uPyeOw8GDYjaZoVdWeKm-bGYHbx3T4sZvK2n5syRNJwh7_lsYkRn6ZsKMryjQkHhN1Jz68L50iy8nO_ujejjnY_LZdrzcAg3f3NMAnO3NW-eOJvmhk0U7jPE9zFNUc4G1VzI2Z6RCg&v=5.131";

// Получение данных из API
$response = file_get_contents($api_url);
$data = json_decode($response, true);

// Проверка, чтобы убедиться, что есть данные для обработки
if (isset($data['response']) && isset($data['response']['items'])) {
    $items = $data['response']['items'];
    $output = '<div class="container">';

    // Функция для проверки доступности URL
    function isUrlAccessible($url) {
        if (empty($url)) {
            return false;
        }
        $headers = @get_headers($url);
        return is_array($headers) && strpos($headers[0], '200') !== false;
    }

    // Проверка доступности и сбор информации
    foreach ($items as $item) {
        if (isset($item['url']) && isUrlAccessible($item['url'])) {
            $output .= '<p>Исполнитель: ' . htmlspecialchars($item['artist']) . '<br>';
            $output .= 'Название: ' . htmlspecialchars($item['title']) . '<br>';
            $output .= '<a href="' . htmlspecialchars($item['url']) . '">Ссылка</a></p>';
        }
    }
    $output .= "</div>";

    // Сохранение в файл
    $filename = THEME_PAGE_PATH . 'audio.php';
    file_put_contents($filename, $output);

    echo "Результаты успешно сохранены в файл $filename.";
} else {
    echo "Не удалось получить данные или данные отсутствуют.";
}
?>