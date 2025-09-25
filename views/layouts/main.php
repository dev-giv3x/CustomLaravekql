<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/main.css">
    <title>Pop it MVC</title>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>

        <?php if (!app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
        <?php else: ?>

            <?php if (app()->auth::user()->role_id === 1): ?>
                <a href="<?= app()->route->getUrl('/admin-panel') ?>">Админ-панель</a>
            <?php endif; ?>

            <?php if (app()->auth::user()->role_id === 2): ?>
                <a href="<?= app()->route->getUrl('/librarian-panel') ?>">Панель библиотекаря</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->login ?>)</a>
        <?php endif; ?>
    </nav>

</header>
<main>
    <?= $content ?>
</main>
</body>
</html>