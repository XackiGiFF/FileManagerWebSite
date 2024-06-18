<?php
// Loading config
global $conn;
    
// Получение общей статистики
$result = $conn->query("SELECT COUNT(*) AS total_files, SUM(download_count) AS total_downloads FROM files");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>Всего загружено: " . $row['total_files'] . " файла(ов) | Всего скачано: " . $row['total_downloads'] . " раз</p>";
} else {
    echo "<p>Ошибка получения статистики файлообменника</p>";
}