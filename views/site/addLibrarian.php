<h2>Выдача ролей</h2>
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

   <label for="role_id">Выберите роль</label>
    <select name="role_id">
        <?php foreach ($roles as $role): ?>
            <option value="<?= $role->id ?>"><?= htmlspecialchars($role->name) ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" class="btn-login">Назначить</button>
</form>
<div class="footer">Библиотечная система &copy; 20254</div>
