<h1>Панель Библиотекаря</h1>

<h3>Список читателей:</h3>
<ol>
    <?php if (!empty($users)): ?>
        <ul>
            <?php foreach ($users as $user): ?>
                <li><?= htmlspecialchars($user) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет читателей</p>
    <?php endif; ?>
</ol>

<h3>Список всех книг:</h3>
<ol>
    <?php if (!empty($books)): ?>
        <ul>
            <?php foreach ($books as $book): ?>
                <li><?= htmlspecialchars($book) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Нет книжек</p>
    <?php endif; ?>
</ol>

<h3>Список взятых книг:</h3>
<?php foreach ($borrowedBooks as $b): ?>
    <li>
        <?= htmlspecialchars($b->book->title ?? 'Неизвестная книга') ?> —
        взял <?= htmlspecialchars($b->reader->user->login ?? 'Неизвестный пользователь') ?>
         <?= htmlspecialchars($b->date_issue) ?>
    </li>
<?php endforeach; ?>