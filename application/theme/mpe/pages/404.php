<?php defined('CORE_LOADED') or die('Hack attempt!'); ?>
<?php http_response_code(404); ?>
<div class="container">
            <h1>Ошибка 404!</h1>
            <p>Запрашиваемая Вами страница не найдена!</p>
            <!-- Добавляем кнопку на главную -->
            <?php get_button_back(); ?>
</div>