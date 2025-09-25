
<h1>Админ Панель</h1>

<?php if (app()->auth::user()->role_id === 1): ?>
    <a href="<?= app()->route->getUrl('/admin-panel/add-librarian') ?>">Выдать роль пользователю</a>
<?php endif; ?>

<h3>Список библиотекарей:</h3>
<ol>
    <?php if (!empty($users)): ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет библиотекарей</p>
    <?php endif; ?>
</ol>

<div>Библиотечная система 1320254</div>