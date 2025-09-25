<h3>Топ 10 книг по популярности:</h3>

<?php if (count($popularBooks) === 0): ?>
    <p>Нет данных</p>
<?php else: ?>
    <ol>
        <?php foreach ($popularBooks as $book): ?>
            <li>
                <?= htmlspecialchars($book->title ?? 'Неизвестная книга') ?> —
                количество выдач: <?= htmlspecialchars($book->borrowed_books_count) ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>
