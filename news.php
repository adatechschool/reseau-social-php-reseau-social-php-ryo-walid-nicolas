<?php
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php";
?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Actualités</title>
    <meta name="author" content="nicotine189">
    <link rel="stylesheet" href="./client/css/style.css" />
</head>

<body>
    <?php include './client/header.php'; ?>

    <div id="wrapper">
        <aside>
            <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les derniers messages de
                    tous les utilisatrices du site.</p>
            </section>
        </aside>
        <main>

            <!-- récupération des données depuis la DB  -->
            <?php
            $lesInformations = $mysqli->query($SQL_news);
            // Vérification
            checkQueryResult($lesInformations, $mysqli);

            // Boucle pour l'affichage des articles
            while ($post = $lesInformations->fetch_assoc()) {

                // echo "<pre>" . print_r($post, 1) . "</pre>";
            ?>
                <article>
                    <h3>
                        <time><?php echo $post['created'] ?></time>
                    </h3>
                    <address><?php echo '<a href="wall.php?user_id=' . $post['author_id'] . '">' . $post['author_name'] . '</a>'; ?></address>

                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>
                    <footer>
                        <small>♥ <?php echo $post['like_number'] ?></small>
                        <a href=""><?php echo $post['taglist'] ?></a>,
                    </footer>
                </article>
            <?php
            }
            ?>
        </main>
    </div>
</body>

</html>