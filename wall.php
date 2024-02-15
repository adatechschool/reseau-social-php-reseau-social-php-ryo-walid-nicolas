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

            $listAuteurs = [];
            $laQuestionEnSql = "SELECT * FROM users";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            while ($user = $lesInformations->fetch_assoc()) {
                $listAuteurs[$user['id']] = $user['alias'];
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['follow_user'])) {
                // Check if the user is logged in
                if (isset($_SESSION['user_id'])) {
                    $follower_id = $_SESSION['user_id'];
                    $user_id = $userId; // Assuming $userId is set somewhere
                    // Save subscription data to the database
                    $stmt = $mysqli->prepare("INSERT INTO subscriptions (follower_id, user_id) VALUES (?, ?)");
                    $stmt->bind_param("ii", $follower_id, $user_id);

                    if ($stmt->execute()) {
                        // Successful insertion
                    } else {
                        echo "Error: " . $mysqli->error;
                    }

                    $stmt->close();
                }
            }
            ?>


            <?php
            $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
            $lesInformations = $mysqli->query($laQuestionEnSql);
            $user = $lesInformations->fetch_assoc();
            // echo "<pre>" . print_r($user, 1) . "</pre>";
            ?>

            <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <form action=<?= $_SERVER['REQUEST_URI'] ?> method="post">
                    <h2>Ajouter un message</h2>
                    <label for="message_content">Contenu du message:</label><br>
                    <textarea id="message_content" name="message_content" rows="4" cols="50" required></textarea><br>
                    <input type="submit" value="Ajouter le message">
                </form>
                <h3>Présentation</h3>

                <?php

                $listAuteurs = [];
                $laQuestionEnSql = "SELECT * FROM users WHERE id = {$_SESSION['connected_id']} ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                ?>
                <!-- //echo "<pre>" . print_r($user, 1) . "</pre>"; -->


                <p>Sur cette page vous trouverez tous les message de l'utilisatrice : <?= $user['alias'] ?>
                    (n° <?php echo $_SESSION['connected_id']; ?>)
                </p>



                <?php

                $enCoursDeTraitement = isset($_POST['message_content']);
                if ($enCoursDeTraitement) {

                    // récupération des données du formulaire
                    //echo "<pre>" . print_r($_POST, 1) . "</pre>";
                    $authorId = $_SESSION['connected_id'];
                    $postContent = $_POST['message_content'];

                    // Sécurisation pour injections SQL
                    $authorId = intval($mysqli->real_escape_string($authorId));
                    $postContent = $mysqli->real_escape_string($postContent);

                    // requête SQL ajout post
                    $lInstructionSql = "INSERT INTO posts
                (id, user_id, content, created, parent_id)
                VALUES (NULL, $authorId, '$postContent', NOW(), NULL)";

                    // echo $lInstructionSql;
                    // // Etape 5 : execution
                    $ok = $mysqli->query($lInstructionSql);
                    if (!$ok) {
                        echo "Impossible d'ajouter le message: " . $mysqli->error;
                    } else {
                        echo "Message posté en tant que :" . $user['alias'];
                    }
                }

                ?>

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