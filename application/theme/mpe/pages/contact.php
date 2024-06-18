<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php
global $pageTitle, $metaDescription, $metaKeywords, $metaAuthor, $metaTitle, $ogImageGlobal, $ogUrlGlobal;

// Переопределение мета-данных для страницы "Контакты"
$pageTitle = 'Контакты |' . META_TITLE;
$metaDescription = 'Свяжитесь с нами через нашу контактную форму.';
$metaKeywords = 'контакт, форма, email';
$metaTitle = 'Контакты |' . META_TITLE;
$ogUrlGlobal = OG_URL . 'contact';
?>

<div class="container">
    <h1>Связаться с нами</h1>
    <div id="form-message"></div>
        <form id="contact-form" method="post" class="contact-form">
            <div class="contact-form-group">
                <label for="name" class="contact-form-label">Имя:</label>
                <input type="text" id="name" name="name" class="contact-form-input" required>
            </div>
            <div class="contact-form-group">
                <label for="email" class="contact-form-label">Email:</label>
                <input type="email" id="email" name="email" class="contact-form-input" required>
            </div>
            <div class="contact-form-group">
                <label for="message" class="contact-form-label">Сообщение:</label>
                <textarea id="message" name="message" class="contact-form-textarea" rows="5" required></textarea>
            </div>
            <button type="submit" class="contact-form-btn">Отправить</button>
        </form>
        <?php get_button_back(); ?>
</div>

<script>
document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    var name = formData.get('name').trim();
    var email = formData.get('email').trim();
    var message = formData.get('message').trim();

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!name || !email || !message) {
        displayMessage('error', 'Пожалуйста, заполните все обязательные поля.');
        return;
    }

    if (!emailPattern.test(email)) {
        displayMessage('error', 'Пожалуйста, введите действительный email.');
        return;
    }

    fetch('/application/api/contact-submit.php', {
        method: 'POST',
        body: formData
    }).then(function(response) {
        return response.json();
    }).then(function(data) {
        if (data.success) {
            displayMessage('success', data.message);
        } else {
            displayMessage('error', data.message);
        }
    }).catch(function(error) {
        console.error('Error:', error);
        displayMessage('error', 'Ошибка при отправке сообщения. Пожалуйста, попробуйте еще раз.');
    });
});

function displayMessage(type, message) {
    var messageDiv = document.getElementById('form-message');
    messageDiv.innerHTML = '<p class="' + type + '">' + message + '</p>';
}
</script>