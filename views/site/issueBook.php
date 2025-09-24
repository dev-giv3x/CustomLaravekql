<link rel="stylesheet" href="../public/css/issue_book.css">

<h2>Выдача книг</h2>
<h3><?= $message ?? ''; ?></h3>

<form method="POST" class="issue-book-form">
    <label for="book_id">Выберите книгу</label>
    <select name="book_id" id="book_id" required>
        <option>---выберите книгу---</option>
        <?php foreach ($books as $book): ?>
            <option value="<?= $book->id ?>"><?= htmlspecialchars($book->title) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="user_id">Выберите пользователя</label>
    <select name="user_id" id="user_id" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->id ?>"><?= htmlspecialchars($user->login) ?></option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Выдать книгу</button>
</form>

<div class="footer">Библиотечная система &copy; 20254</div>
