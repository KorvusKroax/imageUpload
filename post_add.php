<?php
    require("db_functions.php");



    $title = (isset($_POST["title"])) ? $_POST["title"] : "";



    if (isset($_GET["select"]))
    {
        if (($key = array_search($_GET["select"], $_SESSION["images"])) !== false)
        {
            $tmp = $_SESSION["images"][0];
            $_SESSION["images"][0] = $_SESSION["images"][$key];
            $_SESSION["images"][$key] = $tmp;
        }
    }


    
    if (isset($_GET["remove"]))
    {
        if (($key = array_search($_GET["remove"], $_SESSION["images"])) !== false)
        {
            unset($_SESSION["images"][$key]);
            $_SESSION["images"] = array_values($_SESSION["images"]);

            unlink("tmp/" . $_GET["remove"]);
        }
    }



    if (isset($_POST["upload"]))
    {
        if (!empty(array_filter($_FILES["images"]["name"])))
        {
            if (!isset($_SESSION["images"]))
            {
                mkdir("tmp");
                $_SESSION["images"] = [];
            }

            foreach($_FILES["images"]["name"] as $key=>$val)
            {
                $fileName = basename($_FILES["images"]["name"][$key]);
                
                // $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                // if (in_array($fileType, ["jpg", "jpeg", "png", "gif"]))
                // {
                    if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], "tmp/" . $fileName))
                    {
                        if (!in_array($fileName, $_SESSION["images"]))
                        {
                            array_push($_SESSION["images"], $fileName);
                        }
                    }
                    else echo "unable to upload: <b>$fileName</b><br>";
                // }
                // else echo "wrong file type: <b>$fileName</b> (jpg, jpeg, png, gif only)<br>";
            }
        }
        else echo "no file selected<br>";
    }


    
    if (isset($_POST["submit"]))
    {
        addNewArticle($title, json_encode($_SESSION["images"]));
        
        foreach($_SESSION["images"] as $image) rename("tmp/$image", "uploads/$image");
        unset($_SESSION["images"]);
        rmdir("tmp");

        header("location: index.php");
        exit();
    }


    
    if (isset($_POST["cancel"]))
    {
        foreach($_SESSION["images"] as $image) unlink("tmp/" . $image);
        unset($_SESSION["images"]);
        rmdir("tmp");

        header("location: index.php");
        exit();
    }
?>



<?php require("header.php"); ?>

<main>
    <form method="post" enctype="multipart/form-data">
        <input class="input-text" type="text" name="title" value="<?= $title ?>" placeholder="title">
        <br>
        <br>

        <?php if (isset($_SESSION["images"])) : ?>
            <div id="uploaded-image-container" class="image-container">
                <?php foreach($_SESSION["images"] as $imagePath) : ?>
                    <div class="image-item-holder">
                        <button class="remove-button" onclick="location.href='post_add.php?remove=<?= $imagePath ?>'"><b>x</b></button>
                        <button class="image-button" onclick="location.href='post_add.php?select=<?= $imagePath ?>'"><img class="image-item" src="tmp/<?= $imagePath ?>"></button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <br>

        <label id="input-files-label" class="button" for="input-files">Kép feltöltés</label>
        <input id="input-files" type="file" accept="image/*" name="images[]" onchange="document.getElementById('upload-button').click()" multiple hidden>
        <input id="upload-button" type="submit" name="upload" hidden>

        <label id="submit-button-label" class="button" for="submit-button">Mentés</label>
        <input id="submit-button" type="submit" name="submit" hidden>

        <label id="cancel-button-label" class="button" for="cancel-button">Mégse</label>
        <input id="cancel-button" type="submit" name="cancel" hidden>

    </form>
</main>

<?php require("footer.php"); ?>
