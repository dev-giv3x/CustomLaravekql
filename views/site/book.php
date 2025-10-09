<link rel="stylesheet" href="../public/css/book.css">

<h1>Добро пожаловать в библиотечную систему!!!</h1>
<h2>Доступные для чтения книги</h2>

<div class="books-grid">
    <?php foreach ($books as $book): ?>
        <div class="book-card">
            <a href="/books/<?= $book->id ?>">
                <?php if (!empty($book->image_path)): ?>
                    <img src="<?= htmlspecialchars($book->image_path) ?>" alt="<?= htmlspecialchars($book->title) ?>">
                <?php endif; ?>
                <div class="book-title"><?= htmlspecialchars($book->title) ?></div>
            </a>
        </div>
    <?php endforeach; ?>
</div>