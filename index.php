<?php
    require("db_functions.php");

    $articles = getAllArticles();
?>



<?php require("header.php") ?>

<main>
    <button class="button" onclick="location.href='post_add.php'">Új hozzáadás</button>
    <br>
    <br>

    <table>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>images</th>
        </tr>

        <?php if(empty($articles)) : ?>

            <tr><td colspan="3">no article..</td></tr>

        <?php else : ?>

            <?php foreach($articles as $article) : ?>
                <tr onclick="location.href='post_view.php?id=<?= $article['id'] ?>'">
                    <td><?= $article["id"] ?></td>
                    <td><?= $article["title"] ?></td>
                    <td><?= $article["images"] ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </table>
</main>

<?php require("footer.php") ?>
