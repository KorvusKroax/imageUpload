<?php
    require("db_functions.php");

    $article = getArticleByID($_GET["id"]);

    $id = $article[0]["id"];
    $title = $article[0]["title"];
    $images = json_decode($article[0]["images"]);
?>



<?php require("header.php"); ?>

<main>
    <span>id: <?= $id ?></span><br>
    <br>
    <span>title: <?= $title ?></span><br>
    <br>
    <div id='uploaded-image-container'>
        <?php foreach($images as $image) : ?>
            <img class="image-item" src="uploads/<?= $image ?>">
        <?php endforeach; ?>
    </div>
    <br>
    <button onclick="location.href='index.php'">back</button><br>
</main>

<?php require("footer.php"); ?>
