</main>
<footer>
    <?php get_metrika(); ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var hamburger = document.querySelector(".hamburger-menu");
        var mobileNav = document.getElementById("mobile-nav");
        var closeButton = document.getElementById("close-button");

        hamburger.addEventListener("click", function() {
            if (mobileNav.classList.contains("open")) {
                mobileNav.classList.remove("open");
                mobileNav.classList.add("close");
            } else {
                mobileNav.classList.remove("close");
                mobileNav.classList.add("open");
            }
        });

        closeButton.addEventListener("click", function() {
            mobileNav.classList.remove("open");
            mobileNav.classList.add("close");
        });
    });
</script>
<?php if(isset($_SESSION['notification'])): ?>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const notification = document.querySelector('.notification');
    const notificationData = <?php echo json_encode($_SESSION['notification']); ?>;
    
    notification.classList.add(notificationData[0]); // Добавляем класс на основе статуса (success/error)
    notification.innerHTML = notificationData[1]; // Используем innerHTML для корректного отображения HTML-тегов
    notification.style.display = 'block'; // Показываем уведомление
    
    setTimeout(() => {
        notification.style.display = 'none'; // Скрываем уведомление через 5 секунд
    }, 5000);
    
    <?php if(isset($_SESSION['notification']['redirectTo'])): ?>
        setTimeout(() => {
            window.location.href = '<?php echo $_SESSION['notification']['redirectTo']; ?>';
        }, 2000); // Редирект через 2 секунды
    <?php endif; ?>
});
</script>
<?php unset($_SESSION['notification']); // Удаляем уведомление из сессии после его отображения ?>
<?php endif; ?>
</footer>
</body>
</html>