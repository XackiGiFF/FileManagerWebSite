<div class="container">
   <h1>Личный кабинет</h1>
    <?php if (isset($_SESSION['userId'])): ?>
        <h1>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['nickname']); ?>!</h1>
        <h2>Настройки профиля</h2>
        <?php get_snippet('cabinet'); ?>
        <div class="notification"></div>
        <form method="post" action="">
            <div class="settings-form-group">
                <label for="fullname">Никнейм:</label>
                <input type="text" id="nickname" class="settings-form-input" name="nickname" value="<?php echo htmlspecialchars($_SESSION['nickname']); ?>" required>
            </div>
            <div class="settings-form-group">
                <label for="fullname">ФИО:</label>
                <input type="text" id="fullname" class="settings-form-input" name="fullname" value="<?php echo htmlspecialchars($_SESSION['fullname']); ?>" required>
            </div>
            <div class="settings-form-group">
                <label for="phone">Телефон:</label>
                <input type="text" id="phone" class="settings-form-input" name="phone" value="<?php echo htmlspecialchars($_SESSION['phone']); ?>" required>
            </div>
            <div class="settings-form-group">
                <label for="vk_link">Ссылка на VK:</label>
                <input type="text" id="vk_link" class="settings-form-input" name="vk_link" value="<?php echo htmlspecialchars($_SESSION['vk_link']); ?>">
            </div>
            <div class="settings-form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" class="settings-form-input" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
            </div>
            <div class="settings-form-group">
                <label for="working_hours">Сколько часов в месяц готовы работать:</label>
                <input type="number" id="working_hours" class="settings-form-input" name="working_hours" value="<?php echo htmlspecialchars($_SESSION['working_hours']); ?>" required>
            </div>
            <div class="auth-buttons">
                <input type="submit" value="Сохранить изменения" class="form-btn">
            </div>
        </form>
    <?php else: ?>
        <h1>Здравствуйте, Гость!</h1>
        <div class="auth-buttons">
            <?php get_button_log(); ?>
            <?php get_button_reg(); ?>
        </div>
    <?php endif; ?>
    <?php get_button_back(); ?>
</div>
