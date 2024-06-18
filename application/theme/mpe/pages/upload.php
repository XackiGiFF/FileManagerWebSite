<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php $conn = get_connection(); ?>
<div class="container">
    <h1>Файловый менеджер</h1>
    <h3>Загрузка файла в хранилище</h3>
    <?php
    // Проверка, передан ли файл
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_FILES['fileToUpload'])) {
            $file = $_FILES['fileToUpload'];
            $originalFileName = $file['name'];
            $fileTmpName = $file['tmp_name'];
            $fileData = file_get_contents($fileTmpName);
            $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    
            // Генерация уникального имени с включением реального имени
            $generatedName = uniqid() . '_' . $originalFileName;
            
            //$scanId = scanFileWithVirusTotal($fileTmpName, $apiKey);
    
            // Пауза для получения отчета
            //sleep(10);
            
            if (isset($_POST['encrypt']) && isset($_POST['password'])) {
                // Пользователь выбрал шифрование
                $password = $_POST['password'];
                $hashedPassword = hashPassword($password);
                $encryptedData = encryptFileData($fileData, $password);
                $stmt = $conn->prepare("INSERT INTO files (file_name, generated_name, file_data, password_hash) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $originalFileName, $generatedName, $encryptedData, $hashedPassword);
            } else {
                // Пользователь не выбрал шифрование
                $stmt = $conn->prepare("INSERT INTO files (file_name, generated_name, file_data, password_hash) VALUES (?, ?, ?, NULL)");
                $stmt->bind_param("sss", $originalFileName, $generatedName, $fileData);
            }
    
    
            if ($stmt->execute()) {
                // Генерация ссылки на файл
                $fileURL = '/files/' . $generatedName;
                echo "Файл успешно загружен!</p>";
                echo "<ul class='file-list'><li><a href='" . $fileURL . "'>Скачать файл</a></li></ul>";
            } else {
                echo "Ошибка при загрузке файла.";
            }
    
            $stmt->close();
        } else {
            echo "Не выбран файл для загрузки.";
        }
    } else {
        ?>
        <?php get_snippet('upload_manager_file_form'); // Включаем вывод формы менеджера ?>
        <?php get_snippet('statistics'); // Включаем статистику ?>
        <?php
        
    }
    
    ?>

    <?php $conn->close(); ?>
    <?php get_button_back(); ?>
</div>