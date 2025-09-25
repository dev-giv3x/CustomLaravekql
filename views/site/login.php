<link rel="stylesheet" href="../public/css/login.css">

<h2>Авторизация</h2>
<h3><?= $message ?? ''; ?></h3>

    <form method="post">
        <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
        <div class="form-group">
            <label for="login">Логин</label>
            <input type="text" id="login" name="login">
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" id="password" name="password">
        </div>
        <button type="submit" class="btn-login">Войти</button>
    </form>
<div class="footer">Библиотечная система &copy; 20254</div>
