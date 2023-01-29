<?php
    require("db_functions.php");

    $article = getArticleByID($_GET["id"]);

    $id = $article[0]["id"];
    $title = $article[0]["title"];
    $images = json_decode($article[0]["images"]);
?>



<?php require("header.php"); ?>

<main>
    <span><b>ID:</b> <?= $id ?></span>
    <br>
    <br>
    
    <span><b>Cím:</b> <?= $title ?></span>
    <br>
    <br>

    <div id="uploaded-image-container" class="image-container">
        <?php foreach($images as $imagePath) : ?>
            <div class="image-item-holder">
                <img class="image-item no-select" src="uploads/<?= $imagePath ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <br>

    <button class="button" onclick="location.href='index.php'">Vissza</button>
</main>

<?php require("footer.php"); ?>
