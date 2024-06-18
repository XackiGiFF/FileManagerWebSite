<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;

// Переопределение мета-данных для страницы "download"
$pageTitle = 'Загрузки | ' . META_TITLE;
$metaDescription = 'Скачивайте файлы легко и безопасно с нашего облачного менеджера! Наслаждайтесь максимальной защитой благодаря шифрованию AES-256 и удобным интерфейсом для управления вашими данными. Присоединяйтесь к тысячам довольных пользователей, оценивших наш сервис для хранения и обеспечения безопасности файлов.';
$metaKeywords = 'скачать файлы, облачный файловый менеджер, шифрование AES-256, защита данных, безопасные загрузки, управление файлами онлайн, онлайн хранилище, защита файлов паролем, удобный интерфейс, надежное хранилище';
$metaTitle = 'Загрузки | ' . META_TITLE;
$ogUrlGlobal = OG_URL . 'files'; // Changed $ogUrl to $ogUrlGlobal to match the global variable name convention
?>
<div class="container">
        <h1>Файловый менеджер</h1>
        <h3>Скачивание файла из хранилища</h3>
    
<?php
// Проверка, передан ли параметр file
if (isset($_GET['file'])) {
    $conn = get_connection();
    
    // Предусматриваем имя файла для загрузки
    $fileName = basename($_GET['file']);

    // Получаем информацию о файле из базы данных
    $stmt = $conn->prepare("SELECT file_name, file_data FROM files WHERE generated_name = ?");
    $stmt->bind_param("s", $fileName);
    $stmt->execute();
    $stmt->store_result();

    // Если есть файл в базе
    if ($stmt->num_rows > 0) {
        $pageTitle = "Загрузка файла {$fileName} | " . META_TITLE;
        $metaTitle = "Загрузка файла {$fileName} | " . META_TITLE;
        $ogUrlGlobal .= '/' .$fileName;
        
        $stmt->bind_result($originalFileName, $fileData);
        $stmt->fetch();

        $stmt1 = $conn->prepare("SELECT password_hash FROM files WHERE generated_name = ?");
        $stmt1->bind_param("s", $fileName);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($passwordHash);
        $stmt1->fetch();

        if (!is_null($passwordHash) && $passwordHash !== '') {
            // Файл зашифрован
            echo <<<HTML
        <p>Файл защищён паролем: $fileName</p>
        <div class="password-container">
            <label for="password">Введите пароль для скачивания:</label>
            <input type="password" id="password" name="password">
            <button id="submit-password">Разблокировать</button>
        </div>
        <p id="error-message" style="color: red; display: none;">Неверный пароль. Попробуйте снова.</p>
HTML;

            echo <<<HTML
<script type="text/javascript">
document.getElementById('submit-password').onclick = function() {
    var password = document.getElementById('password').value;
    if (password) {
        // Отправляем запрос к серверу для проверки пароля
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/application/api/verify_password.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.valid) {
                    // Пароль верный, начинаем таймер перед скачиванием
                    document.getElementById('error-message').style.display = 'none';
                    var countdownElement = document.createElement('p');
                    countdownElement.innerHTML = "Пароль верный! Скачивание начнется через <span id='countdown'>15</span> <span id='seconds-text'>секунд.</span>";
                    document.querySelector('.password-container').appendChild(countdownElement);

                    var seconds = 15;

                    function countdown() {
                        if (seconds >= 0) {
                            document.getElementById('countdown').innerText = seconds;
                            seconds--;
                            setTimeout(countdown, 1000);
                        } else {
                            document.getElementById('seconds-text').style.display = 'none';
                            document.getElementById('countdown').innerText = "Скачивание началось!";
                            // Запускаем скачивание файла после ожидания
                            var fileName = '$fileName';
                            var link = document.createElement('a');
                            link.href = '/application/api/download_file.php?file=' + fileName + '&password=' + encodeURIComponent(password);
                            link.style.display = 'none';
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);
                        }
                    }

                    countdown();
                } else {
                    document.getElementById('error-message').style.display = 'block';
                }
            }
        };
        xhr.send('file=' + encodeURIComponent('$fileName') + '&password=' + encodeURIComponent(password));
    }
};
</script>
HTML;

        } else {
            // Отображаем HTML-код для автоматического запуска скачивания файла с ожиданием
            echo "<p>Файл готовится к скачиванию: $fileName</p>";
            echo "<p>Пожалуйста, подождите... <span id='countdown'>15</span> <span id='seconds-text'>секунд.</span></p>";
            echo "<div id='money-container'>Здесь могла бы быть Ваша реклама.</div>";

            echo <<<HTML
<script type="text/javascript">
window.onload = function() {
    var countdownElement = document.getElementById('countdown');
    var secondsTextElement = document.getElementById('seconds-text');
    var seconds = 15;

    function countdown() {
        if (seconds >= 0) {
            countdownElement.innerText = seconds;
            seconds--;
            setTimeout(countdown, 1000);
        } else {
            secondsTextElement.style.display = 'none';
            countdownElement.innerText = "Скачивание началось!";
            // Запускаем скачивание файла после ожидания
            var fileName = '$fileName';
            var link = document.createElement('a');
            link.href = '/application/api/download_file.php?file=' + fileName;
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    countdown();
};
</script>
HTML;
        }
    } else {
        http_response_code(404);
        echo "Файл не найден или удален!";
    }

    $conn->close();
} else {
    echo "Файл не указан!";
    get_snippet('statistics'); // Включаем статистику
    get_snippet('list_files'); // Включаем список файлов
}
?>
<?php get_button_back(); ?>
</div>