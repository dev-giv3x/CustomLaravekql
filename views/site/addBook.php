<link rel="stylesheet" href="../public/css/add_book.css">

<h2>Добавление книги</h2>
<?php if (!empty($message)): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>
<form enctype="multipart/form-data" method="post">
    <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="form-group">
        <label for="title">Название книги</label>
        <input type="text" id="title" name="title" required >
    </div>
    <div class="form-group">
        <label for="author">Автор книги</label>
        <input type="text" id="author" name="author" required >
    </div>
    <div class="form-group">
        <label for="year_public">Дата издания</label>
        <input type="text" id="year_public" name="year_public" required >
    </div>
    <div class="form-group">
        <label for="price">Цена</label>
        <input type="text" id="price" name="price" required >
    </div>
    <div class="form-group">
        <label for="isNew">Новая?</label>
        <input type="checkbox" value="1" name="is_new">
    </div>
    <div class="form-group">
        <label for="description">Описание</label>
        <input type="text" id="description" name="description" required >
    </div>
    <div class="form-group">
        <label for="image">Загрузить обложку</label>
        <input type="file" id="image" name="image" >
    </div>
    <button type="submit" class="btn-login">Добавить</button>
</form>
<div class="footer">Библиотечная система &copy; 2025</div>
