<?php
    define("DB_DRIVER", "mysql");
    define("DB_NAME", "imageUpload");
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");



    session_start();


    
    if (!isDatabaseExists()) createDatabase();
    if (!isTableExists("articles")) createTable_articles();





    function isDatabaseExists()
    {
        $str = DB_DRIVER . ":hostname=" . DB_HOST;
        $con = new PDO($str, DB_USER, DB_PASSWORD);

        $sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DB_NAME . "'";
        $result = $con->query($sql);

        return (bool) $result->fetchColumn();
    }

    function isTableExists($tablename)
    {
        return dbQuery("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . DB_NAME . "' AND TABLE_NAME = '$tablename'");
    }

    function createDatabase()
    {
        $str = DB_DRIVER . ":hostname=" . DB_HOST;
        $con = new PDO($str, DB_USER, DB_PASSWORD);

        $sql = "CREATE DATABASE " . DB_NAME;
        $con->exec($sql);

        echo "database <b>'" . DB_NAME . "'</b> created<br>";
    }

    function createTable_articles()
    {
        dbQuery("CREATE TABLE articles
        (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title varchar(255) NOT NULL,
            images JSON
        )");
        
        echo "table <b>'articles'</b> created<br>";
    }



    function dbConnect()
    {
        $str = DB_DRIVER . ":hostname=" . DB_HOST . ";dbname=" . DB_NAME;
        $con = new PDO($str, DB_USER, DB_PASSWORD);
        return $con;
    }



    function dbQuery($query, $data = array())
    {
        $con = dbConnect();

        $stm = $con->prepare($query);
        if ($stm) 
        {
            $check = $stm->execute($data);
            if ($check) 
            {
                $result = $stm->fetchAll(PDO::FETCH_ASSOC);
                if (is_array($result) && count($result) > 0) 
                {
                    return $result;
                }
            }
        }
        return false;
    }



    function addNewArticle($title, $images)
    {
        $data["title"] = $title;
        $data["images"] = $images;
        dbQuery("INSERT INTO articles (title, images) VALUES (:title, :images)", $data);

        return "<b>'" . $title . "'</b> című cikk publikálva<br>";
    }

    function getArticleByID($id)
    {
        return dbQuery("SELECT * FROM articles WHERE id = :id LIMIT 1", ["id" => $id]);
    }
    
    function getAllArticles()
    {
        return dbQuery("SELECT * FROM articles");
    }
?>