<?php 
include "./server/db_connect.php";
include "./server/queries.php";
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Les message par mot-clé</title> 
        <meta name="author" content="nicotine189">
        <link rel="stylesheet" href="./client/css/style.css"/>
    </head>
    <body>
        <?php include './client/header.php';?>

        <div id="wrapper">
            <?php
            $tagId = intval($_GET['tag_id']);
            ?>

            <aside>
                <?php
                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();

                // echo "<pre>" . print_r($tag, 1) . "</pre>";
                ?>
                <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le mot-clé "<?php echo $tag['label'] ?>"
                        (n° <?php echo $tagId ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                $lesInformations = $mysqli->query($SQL_tags);
                if ( ! $lesInformations)
                {
                    echo("Échec de la requete : " . $mysqli->error);
                }

                while ($post = $lesInformations->fetch_assoc())
                {

                    //echo "<pre>" . print_r($post, 1) . "</pre>";
                    ?>                
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                        </h3>
                        <address>par <?php echo '<a href="wall.php?user_id=' . $post['author_id'] . '">' . $post['author_name'] . '</a>'; ?></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>                                            
                        <footer>
                            <small>♥ <?php echo $post['like_number'] ?></small>
                            <?php echo '<a href="tags.php?tag_id=' . $post['tag_id'] . '">'?>#<?php echo $post['taglist'] ?></a>
                        </footer>
                    </article>
                <?php } ?>


            </main>
        </div>
    </body>
</html>