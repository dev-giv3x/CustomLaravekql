<form method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <label>Выбрать книгу:
        <select name="book_id">
            <option value="">Все книги</option>
            <?php foreach ($books as $book): ?>
                <option value="<?= $book->id ?>" <?= ($book->id == $bookId) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($book->title) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>
    <button>Показать читателей</button>
</form>

<h3>Читатели, которые брали эту книгу:</h3>

<?php if (count($borrowedBooks) === 0): ?>
    <p>Нет записей</p>
<?php else: ?>
    <ol>
        <?php foreach ($borrowedBooks as $b): ?>
            <li>
                <?= htmlspecialchars($b->reader->user->login ?? 'Неизвестный пользователь') ?> —
                дата выдачи: <?= htmlspecialchars($b->date_issue) ?>,
                дата сдачи: <?= htmlspecialchars($b->date_return) ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>
