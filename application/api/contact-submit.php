<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include $_SERVER['DOCUMENT_ROOT'] . '/application/config.php';
require_once APPLICATION_PATH . 'core/function.php';

require PLUGINS_PATH . 'PHPMailer/src/PHPMailer.php';
require PLUGINS_PATH . 'PHPMailer/src/SMTP.php';
require PLUGINS_PATH . 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Установка заголовков для JSON-ответа
header('Content-Type: application/json');

$response = [];

// Проверка наличия данных в обязательных полях
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
    $response['success'] = false;
    $response['message'] = 'Пожалуйста, заполните все обязательные поля.';
    echo json_encode($response);
    exit;
}

// Get and sanitize input
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Проверка валидности email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['success'] = false;
    $response['message'] = 'Пожалуйста, введите действительный email.';
    echo json_encode($response);
    exit;
}

// Загружаем шаблон для оповещения администрации
ob_start();
include THEME_PATH . 'email_templates/email_contact_form_admin.php';
$adminEmailContent = ob_get_clean();

// Замена меток в шаблоне на реальные данные для администратора
$adminEmailContent = str_replace("{name}", $name, $adminEmailContent);
$adminEmailContent = str_replace("{email}", $email, $adminEmailContent);
$adminEmailContent = str_replace("{message}", nl2br($message), $adminEmailContent);

// Загрузка HTML-шаблона для письма пользователю
ob_start();
include THEME_PATH . 'email_templates/email_contact_form.php';
$userEmailContent = ob_get_clean();

// Замена меток в шаблоне на реальные данные для пользователя
$userEmailContent = str_replace("{name}", $name, $userEmailContent);
$userEmailContent = str_replace("{message}", nl2br($message), $userEmailContent);

$mail = new PHPMailer(true);

try {
    // Настройки сервера
    $mail->isSMTP();
    $mail->Host = 'mail.netangels.ru'; // SMTP сервер
    $mail->SMTPAuth = true;
    $mail->Username = 'coders@mc-mpe.ru'; // Ваш SMTP логин
    $mail->Password = 'Xp96K8Hj!*'; // Ваш SMTP пароль
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Установка кодировки и языка
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', PLUGINS_PATH . 'PHPMailer/language/');
    
    // Отправка письма администрации
    $mail->setFrom($email, $name);
    $mail->addAddress('coders@mc-mpe.ru', 'Admin');
    $mail->isHTML(true);
    $mail->Subject = 'Новое сообщение с сайта';
    $mail->Body = $adminEmailContent;
    $mail->send();

    // Отправка подтверждающего письма пользователю
    $mail->clearAddresses();
    $mail->addAddress($email, $name);
    $mail->isHTML(true);
    $mail->Subject = 'Ваше сообщение было получено';
    $mail->Body = $userEmailContent;
    $mail->send();
    
    $response['success'] = true;
    $response['message'] = 'Спасибо за ваше сообщение! Мы скоро свяжемся с вами.';
    } catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.';
    $response['error'] = $mail->ErrorInfo;
    // Можно добавить отладочную информацию при необходимости:
    // $response['error'] = $mail->ErrorInfo;
}

// Возвращаем JSON-ответ
echo json_encode($response);
?>