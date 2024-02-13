<?php
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php";
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Mur</title>
    <meta name="author" content="nicotine189">
    <link rel="stylesheet" href="./client/css/style.css" />
</head>

<body>
    <?php include './client/header.php'; ?>
    <div id="wrapper">

        <!-- Formulaire abonnement  -->
        <aside>
            <h2>Abonnement</h2>
            <form method="post">
                <button type="submit" name="follow_user">Abonner</button>
            </form>

            <!-- Partie sql pour sauvegarder les suivis  -->

            <?php
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            // echo "<pre>" . print_r($user, 1) . "</pre>";
            ?>

            <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <form action="add_message.php" method="post">
                    <h2>Ajouter un message</h2>
                    <label for="message_content">Contenu du message:</label><br>
                    <textarea id="message_content" name="message_content" rows="4" cols="50" required></textarea><br>
                    <input type="submit" value="Ajouter le message">
                </form>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?php echo $user['alias'] ?>
                    (n° <?php echo $userId ?>)
                </p>

            </section>
        </aside>
        <main>
            <?php
            $lesInformations = $mysqli->query($SQL_wall);
            if (!$lesInformations) {
                echo ("Échec de la requete : " . $mysqli->error);
            }

            while ($post = $lesInformations->fetch_assoc()) {
                // echo "<pre>" . print_r($post, 1) . "</pre>";
            ?>
                <article>
                    <h3>
                        <time datetime='2020-02-01 11:12:13'><?php echo $post['created'] ?></time>
                    </h3>
                    <address>par <?php echo '<a href="wall.php?user_id=' . $post['author_id'] . '">' . $post['author_name'] . '</a>'; ?></address>

                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>
                    <footer>
                        <small>♥ <?php echo $post['like_number'] ?></small>
                        <a href="">#<?php echo $post['taglist'] ?></a>,
                    </footer>
                </article>
            <?php } ?>


        </main>
    </div>
</body>

</html>