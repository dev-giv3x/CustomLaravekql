<h2>Добавление читателя</h2>
<h3><?= $message ?? ''; ?></h3>

<form method="post">
    <label for="user_id">Выберите пользователя</label>
    <select name="user_id" id="user_id" required>
        <?php foreach ($users as $user): ?>
            <option value="<?= $user->id ?>">
                <?= htmlspecialchars($user->login) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="form-group">
        <label for="ticket_number">Номер читательского билета</label>
        <input type="text" id="ticket_number" name="ticket_number" required>
    </div>
    <div class="form-group">
        <label for="firstname">Имя</label>
        <input type="text" id="firstname" name="firstname" required>
    </div>
    <div class="form-group">
        <label for="lastname">Фамилия</label>
        <input type="text" id="lastname" name="lastname" required>
    </div>
    <div class="form-group">
        <label for="patronomic">Отчество</label>
        <input type="text" id="patronomic" name="patronomic" required>
    </div>
    <div class="form-group">
        <label for="phone_number">Номер телефона</label>
        <input type="text" id="phone_number" name="phone_number">
    </div>
    <button type="submit" class="btn-login">Добавить</button>
</form>
<div class="footer">Библиотечная система &copy; 20254</div>
