<h2>Пользователи с активными книгами</h2>
<h3><?= $message ?? ''; ?></h3>

<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <a href="/librarian-panel/return-book/user/<?= $user->id ?>">
                <?= htmlspecialchars($user->login) ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>