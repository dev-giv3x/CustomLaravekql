<link rel="stylesheet" href="../public/css/signup.css">

<h2>Регистрация нового пользователя</h2>
<h3><?= $message ?? ''; ?></h3>

<form method="post">
    <label>Логин <input type="text" name="login"></label>
    <label>Емаил <input type="text" name="email"></label>
    <label>Пароль <input type="password" name="password"></label>
    <button>Зарегистрироваться</button>
</form>