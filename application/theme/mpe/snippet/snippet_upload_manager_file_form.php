<form action="/upload" method="post" enctype="multipart/form-data">
    <label for="fileToUpload">Выберите файл:</label>
    <input type="file" name="fileToUpload" id="fileToUpload" required>
    <div>
    <label for="encrypt">Шифровать файл: <input type="checkbox" name="encrypt" id="encrypt">
    </label>
    </div>

    <div id="passwordSection">
        <label for="password">Введите пароль:</label>
        <input type="password" name="password" id="password">
    </div>
    
    <input type="submit" value="Загрузить файл" name="submit">
</form>
<script>
    document.getElementById('encrypt').addEventListener('change', function() {
        var passwordSection = document.getElementById('passwordSection');
        if (this.checked) {
            passwordSection.style.display = 'block';
        } else {
            passwordSection.style.display = 'none';
        }
    });
</script>