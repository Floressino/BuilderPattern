<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Лаба 1</title>
</head>
<body>
    <form action="Builder.php" method="POST">
        <h1>Добро пожаловать!</h1>
        <div style="margin-bottom: 10px;">
            Имя <input type="text" name="first_name"/>
        </div>
        <div style="margin-bottom: 10px;">
            Фамилия <input type="text" name="last_name" />
        </div>
        <div style="margin-bottom: 10px;">
            <input type="submit" name="EnterAccount" value="Войти" />
            <input type="submit" name="RegAccount" value="Зарегистрироваться" />
        </div>
        <div>
            <input class="btn" type="submit" name="EnterAccountWithVk" value="Авторизоваться через ВК" />
        </div>
    </form>
</body>
</html>