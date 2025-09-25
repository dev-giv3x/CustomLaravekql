<h2>Книги на руках у пользователя</h2>
<?php if ($books->isNotEmpty()): ?>
    <ul>
        <?php foreach ($books as $borrow): ?>
            <li>
                <?= htmlspecialchars($borrow->book->title) ?>
                <form method="POST" action="/librarian-panel/return-book/user/<?= $userId ?>" style="display:inline;">
                    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
                    <input type="hidden" name="book_id" value="<?= $borrow->book_id ?>">
                    <button type="submit">Принять</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>У этого пользователя нет невозвращённых книг.</p>
<?php endif; ?>

<p><a href="/librarian-panel/return-book">Назад к пользователям</a></p>
