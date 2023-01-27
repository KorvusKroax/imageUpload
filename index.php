<?php
    require("db_functions.php");

    $articles = getAllArticles();
?>



<?php require("header.php") ?>

<main>
    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>images</th>
        </tr>
        <?php foreach($articles as $article) : ?>
            <tr onclick="location.href='post_view.php?id=<?= $article["id"] ?>'">
                <td><?= $article["id"] ?></td>
                <td><?= $article["title"] ?></td>
                <td><?= $article["images"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <button onclick="location.href='post_add.php'">add new</button><br>
</main>

<?php require("footer.php") ?>
