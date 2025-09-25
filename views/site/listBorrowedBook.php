<h3>Выбрать пользователя:</h3>
<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <select name="user_id">
        <option value="">Все пользователи</option>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->id ?>" <?= ($user->id == $userId) ? 'selected' : '' ?>>
                <?= htmlspecialchars($user->login) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button>Показать книги</button>
</form>

<h3>Книги, находящиеся у выбранного пользователя:</h3>

<?php if (count($borrowedBooks) === 0): ?>
    <p>Нет взятых книг</p>
<?php else: ?>
    <ol>
        <?php foreach ($borrowedBooks as $b): ?>
            <li>
                <?= htmlspecialchars($b->book->title ?? 'Неизвестная книга') ?> —
                взял <?= htmlspecialchars($b->reader->user->login ?? 'Неизвестный пользователь') ?>,
                дата выдачи: <?= htmlspecialchars($b->date_issue) ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>
