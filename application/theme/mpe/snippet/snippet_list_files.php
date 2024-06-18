<?php
// Loading config
global $page_section;

$conn = get_connection();

// Количество элементов на страницу
$items_per_page = 5;

// Текущая страница
$page = isset($page_section) ? (int)$page_section : 1;
$page = max($page, 1); // Убедимся, что номер страницы не меньше 1

// Вычисляем смещение для SQL-запроса
$offset = ($page - 1) * $items_per_page;

// Получение общего количества файлов
$total_files_result = $conn->query("SELECT COUNT(*) as total_files FROM files");
$total_files_row = $total_files_result->fetch_assoc();
$total_files = $total_files_row['total_files'];

// Проверьте, есть ли хотя бы одна запись
if ($total_files < 1) {
    echo "<p>Файлы пока не загружены</p>";
    exit;
}

// Подсчитываем количество страниц
$total_pages = ceil($total_files / $items_per_page);

// Если номер страницы превышает количество страниц, перенаправляем пользователя на последнюю страницу
if ($page > $total_pages) {
    echo "<script>window.location.href = '?page_section=" . $total_pages . "';</script>";
    exit;
}


// Получение списка файлов и их статистики с учетом пагинации
$stmt = $conn->prepare("SELECT file_name, generated_name, download_count, upload_datetime FROM files ORDER BY upload_datetime DESC LIMIT ? OFFSET ?");
$stmt->bind_param("ii", $items_per_page, $offset);

// Выполнение запроса
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<ul class='file-list'>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><a href='/files/" . $row['generated_name'] . "'>" . htmlspecialchars($row['file_name']) . " — Скачано " . $row['download_count'] . " раз, Загружено: " . $row['upload_datetime'] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "<p>Файлы пока не загружены</p>";
}

// Подсчитываем количество страниц
$total_pages = ceil($total_files / $items_per_page);

// Выводим кнопки пагинации, если страниц больше одной
if ($total_pages > 1) {
    echo "<div class='pagination'>";
    
    // Кнопка "Назад"
    if ($page > 1) {
        echo "<a href='?page_section=" . ($page - 1) . "' class='btn-pagination'>Назад</a>";
    }

    // Первая страница
    if ($page == 1) {
        echo "<span class='current-page'>1</span>";
    } else {
        echo "<a href='?page_section=1' class='btn-pagination'>1</a>";
    }

    if ($total_pages > 5) {
        // Текущая страница - средняя страница
        $start = max(2, $page - 1);
        $end = min($total_pages - 1, $page + 1);

        if ($start > 2) {
            echo "<span class='btn-pagination'>...</span>";
        }

        for ($i = $start; $i <= $end; $i++) {
            if ($i == $page) {
                echo "<span class='current-page'>" . $i . "</span>";
            } else {
                echo "<a href='?page_section=" . $i . "' class='btn-pagination'>" . $i . "</a>";
            }
        }

        if ($end < $total_pages - 1) {
            echo "<span class='btn-pagination'>...</span>";
        }

        // Последняя страница
        if ($page == $total_pages) {
            echo "<span class='current-page'>" . $total_pages . "</span>";
        } else {
            echo "<a href='?page_section=" . $total_pages . "' class='btn-pagination'>" . $total_pages . "</a>";
        }
    } else {
        // Если страниц меньше или равно 5
        for ($i = 2; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<span class='current-page'>" . $i . "</span>";
            } else {
                echo "<a href='?page_section=" . $i . "' class='btn-pagination'>" . $i . "</a>";
            }
        }
    }
    
    // Кнопка "Вперед"
    if ($page < $total_pages) {
        echo "<a href='?page_section=" . ($page + 1) . "' class='btn-pagination'>Вперед</a>";
    }
    
    echo "</div>";
}


$conn->close();
?>