<?php 
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php"
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Administration</title> 
        <meta name="author" content="nicotine189">
        <link rel="stylesheet" href="./client/css/style.css"/>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz@6..12&display=swap" rel="stylesheet">
    </head>
    <body>
        <?php include './client/header.php';?>

        <div id="wrapper" class='admin'>
            <aside>
                <h2>Mots-clés</h2>
                <?php
                // Récupération des données de la base + check si ok
                $lesInformations = $mysqli->query($SQL_50_First_tags);
                checkQueryResult($lesInformations, $mysqli);

                                // Boucle pour créer les bulles
                while ($tag = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>"; #Affiche "raw" contenu de la requête
                    ?>
                    <article>
                        <h3><?php echo $tag['label'] ?></h3>
                        <p>id:<?php echo $tag['id'] ?></p>
                        <nav>
                            <a href="tags.php?tag_id=<?php echo $tag['id'] ?>">Messages</a>
                        </nav>
                    </article>
                <?php } ?>
            </aside>

            <main>
                <h2>Utilisatrices</h2>
                <?php
                
                // Récupération des données de la base + check si ok
                $lesInformations = $mysqli->query($SQL_50_First_Users);
                checkQueryResult($lesInformations, $mysqli);


                while ($tag = $lesInformations->fetch_assoc())
                {
                    // echo "<pre>" . print_r($tag, 1) . "</pre>";
                    ?>
                    <article>
                        <h3><?php echo $tag['alias'] ?></h3>
                        <p>id:<?php echo $tag['id'] ?></p>
                        <nav>
                            | <a href="wall.php?user_id=<?php echo $tag['id'] ?>">Mur</a>
                            | <a href="feed.php?user_id=<?php echo $tag['id'] ?>">Flux</a>
                            | <a href="settings.php?user_id=<?php echo $tag['id'] ?>">Paramètres</a>
                            | <a href="followers.php?user_id=<?php echo $tag['id'] ?>">Suiveurs</a>
                            | <a href="subscriptions.php?user_id=<?php echo $tag['id'] ?>123">Abonnements</a>
                        </nav>
                    </article>
                <?php } ?>
            </main>
        </div>
    </body>
</html>
