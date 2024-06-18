<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
        }
        .content {
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Спасибо за ваше сообщение!</h1>
        </div>
        <div class="content">
            <p>Уважаемый(ая) {name},</p>
            <p>Спасибо за то, что связались с нами. Мы получили ваше сообщение и ответим вам в ближайшее время.</p>
            <p>Ваше сообщение:</p>
            <blockquote>
                <p>{message}</p>
            </blockquote>
        </div>
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?>, MPE-Coders. Все права защищены.</p>
        </div>
    </div>
</body>
</html>