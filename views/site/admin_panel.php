<h1>Админ Панель</h1>

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