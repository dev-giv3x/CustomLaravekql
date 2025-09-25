<!--<link rel="stylesheet" href="../public/css/librarian_panel.css">-->

<h1>Панель Библиотекаря</h1>

    <?php if (app()->auth::user()->role_id === 2): ?>
        <a href="<?= app()->route->getUrl('/librarian-panel/add-book') ?>">Добавить книгу</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/add-reader') ?>">Добавить читателя</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/issue-book') ?>">Выдать книгу</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/return-book') ?>">Принять книгу</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/log') ?>">Выписка взятых книг</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/readers/borrowed-book') ?>">История выдач</a>
        <a href="<?= app()->route->getUrl('/librarian-panel/popular-books') ?>">Популярные книги</a>
    <?php endif; ?>

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
    <ol>
        <?= htmlspecialchars($b->book->title ?? 'Неизвестная книга') ?> —
        взял <?= htmlspecialchars($b->reader->user->login ?? 'Неизвестный пользователь') ?>
         <?= htmlspecialchars($b->date_issue) ?>
    </ol>
<?php endforeach; ?>