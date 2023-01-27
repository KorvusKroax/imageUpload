<?php
    require("db_functions.php");

    if (isset($_POST["submit"]))
    {
        $no_error = false;
        $title = $_POST["title"];

        $imageNames = [];
        if (!empty(array_filter($_FILES["images"]["name"])))
        {
            foreach($_FILES["images"]["name"] as $key=>$val)
            {
                $fileName = $_FILES["images"]["name"][$key];
                $tempName = $_FILES["images"]["tmp_name"][$key];

                $targetFilePath = "uploads/" . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                if (in_array($fileType, ["jpg", "jpeg", "png", "gif"]))
                {
                    if (move_uploaded_file($tempName, $targetFilePath))
                    {
                        array_push($imageNames, $fileName);
                        $no_error = true;
                    }
                    else echo "unable to upload: <b>$fileName</b><br>";
                }
                else echo "wrong file type: <b>$fileName</b> (jpg, jpeg, png, gif only)<br>";
            }
        }
        else echo "no file selected<br>";

        if ($no_error)
        {
            addNewArticle($title, json_encode($imageNames));

            header("location: index.php");
            exit();
        }
    }
?>



<?php require("header.php"); ?>

<main>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="title"><br>
        <br>
        <div id="input-image-container"></div><br>
        <input id="input-file" type="file" name="images[]" onchange="uploadImage()" multiple><br>
        <br>
        <input type="submit" name="submit" value="submit"><br>
        <br>
    </form>
</main>

<?php require("footer.php"); ?>
