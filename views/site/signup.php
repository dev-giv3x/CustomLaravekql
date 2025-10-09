<link rel="stylesheet" href="../public/css/signup.css">

<h2>Регистрация нового пользователя</h2>

<?php if (!empty($message)): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Логин <input type="text" name="login"></label>
    <label>Емаил <input type="text" name="email"></label>
    <label>Пароль <input type="password" name="password"></label>
    <button>Зарегистрироваться</button>
</form>