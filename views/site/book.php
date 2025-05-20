<h1>Список книг</h1>
<ol>
    <?php
    foreach ($books as $book) {
        echo '<li>' . $book->title . '</li>';
    }
    ?>
</ol>