<link rel="stylesheet" href="../public/css/books.css">

<div class="book-detail">
    <h1><?= htmlspecialchars($book->title) ?></h1>

    <?php if (!empty($book->image_path)): ?>
        <img src="<?= htmlspecialchars($book->image_path) ?>" alt="<?= htmlspecialchars($book->title) ?>">
    <?php endif; ?>

    <p><strong>Автор:</strong> <?= htmlspecialchars($book->author) ?></p>
    <p><strong>Год публикации:</strong> <?= htmlspecialchars($book->year_public) ?></p>
    <p><strong>Цена:</strong> <?= htmlspecialchars($book->price) ?></p>
    <p><strong>Описание:</strong> <?= htmlspecialchars($book->description) ?></p>
</div>