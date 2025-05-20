<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Библиотечная система</title>
</head>
<body>
<div class="container" id="loginPage">
    <h1>Вход в систему</h1>
    <form method="POST">
    <div id="loginError" class="error hidden"></div>
    <label for="usernameInput">Имя пользователя</label>
    <input type="text" id="usernameInput" autocomplete="username">
    <label for="passwordInput">Пароль</label>
    <input type="password" id="passwordInput" autocomplete="current-password">
    <button id="loginBtn">Войти</button>
    </form>
</div>
<div class="footer">Библиотечная система &copy; 20254</div>
</body>
</html>