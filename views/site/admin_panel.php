<h1>Админ Панель</h1>

<h3>Список библиотекарей:</h3>
<ol>
    <?php
    foreach ($users as $user) {
        echo '<li>' . $user->login . '</li>';
    }
    ?>
</ol>

<div>Библиотечная система 1320254</div>