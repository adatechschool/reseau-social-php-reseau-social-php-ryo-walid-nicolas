<?php 
include "./server/db_connect.php";
include "./server/queries.php";
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Flux</title>         
        <meta name="author" content="nicotine189">
        <link rel="stylesheet" href="./client/css/style.css"/>
    </head>
    <body>
        <?php include './client/header.php';?>

        <div id="wrapper">
            <aside>
                <?php
                $lesInformations = $mysqli->query($SQL_getUserFromId);
                $user = $lesInformations->fetch_assoc();
                // echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>
                <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez tous les message des utilisatrices
                        auxquel est abonnée l'utilisatrice <?php echo '<a href="wall.php?user_id=' . $userId . '">' . $user['alias'] . '</a>'; ?>
                        (n° <?php echo $userId; ?>)
                    </p>

                </section>
            </aside>
            <main>
                <?php
                $lesInformations = $mysqli->query($SQL_Get_Subscribed_Posts);
                checkQueryResult($lesInformations, $mysqli);


                // Boucle pour l'affichage des articles
                while ($feeds = $lesInformations->fetch_assoc())
                {
                    
                    // echo "<pre>" . print_r($feeds, 1) . "</pre>";
                    ?>
                <article>
                    <h3>
                        <time datetime='2020-02-01 11:12:13' ><?php echo $feeds['created'] ?></time>
                    </h3>
                    <address>par <?php echo '<a href="wall.php?user_id=' . $feeds['author_id'] . '">' . $feeds['author_name'] . '</a>'; ?></address>
                    <div>
                        <p><?php echo $feeds['content'] ?></p>


                    </div>                                            
                    <footer>
                        <small>♥ <?php echo $feeds['like_number'] ?></small>
                        <a href="">#<?php echo $feeds['taglist'] ?></a>,
                    </footer>
                </article>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>
