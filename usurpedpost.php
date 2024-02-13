<?php
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php";
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Post d'usurpateur</title>
    <meta name="author" content="nicotine189">
    <link rel="stylesheet" href="./client/css/style.css" />
</head>

<body>
    <?php include './client/header.php'; ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Sur cette page on peut poster un message en se faisant
                passer pour quelqu'un d'autre</p>
        </aside>
        <main>
            <article>
                <h2>Poster un message</h2>
                <?php
                /**
                 * Récupération de la liste des auteurs
                 */
                $listAuteurs = [];
                $laQuestionEnSql = "SELECT * FROM users";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                while ($user = $lesInformations->fetch_assoc()) {
                    $listAuteurs[$user['id']] = $user['alias'];
                }


                // Trautement du formulaire de soumission de nouveaux commentaires
                $enCoursDeTraitement = isset($_POST['auteur']);
                if ($enCoursDeTraitement) {

                    // récupération des données du formulaire
                    // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                    $authorId = $_POST['auteur'];
                    $postContent = $_POST['message'];

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
                        echo "Message posté en tant que :" . $listAuteurs[$authorId];
                    }
                }

                ?>
                <form action="usurpedpost.php" method="post">
                    <input type='hidden' name='???' value='achanger'>
                    <dl>
                        <dt><label for='auteur'>Auteur</label></dt>
                        <dd><select name='auteur'>
                                <?php
                                foreach ($listAuteurs as $id => $alias)
                                    echo "<option value='$id'>$alias</option>";
                                ?>
                            </select></dd>
                        <dt><label for='message'>Message</label></dt>
                        <dd><textarea name='message'></textarea></dd>
                    </dl>
                    <input type='submit'>
                </form>
            </article>
        </main>
    </div>
</body>

</html>