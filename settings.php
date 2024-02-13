<?php 
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php"
?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Paramètres</title>
    <meta name="author" content="nicotine189">
    <link rel="stylesheet" href="./client/css/style.css" />
</head>

<body>
    <?php include './client/header.php'; ?>

    <div id="wrapper" class='profile'>
        <aside>
            <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice" />
            <section>
                <h3>Présentation</h3>
                <p>Sur cette page vous trouverez les informations de l'utilisatrice
                    n° <?php echo $userId ?></p>

            </section>
        </aside>

        <main>
            <?php

            $lesInformations = $mysqli->query($SQL_settings);
            checkQueryResult($lesInformations, $mysqli);

            $user = $lesInformations->fetch_assoc();

            // echo "<pre>" . print_r($user, 1) . "</pre>";
            ?>
            <article class='parameters'>
                <h3>Mes paramètres</h3>
                <dl>
                    <dt>Pseudo</dt>
                    <dd><?php echo $user['alias'] ?></dd>
                    <dt>Email</dt>
                    <dd><?php echo $user['email'] ?></dd>
                    <dt>Nombre de message</dt>
                    <dd><?php echo $user['totalpost'] ?></dd>
                    <dt>Nombre de "J'aime" donnés </dt>
                    <dd><?php echo $user['totalgiven'] ?></dd>
                    <dt>Nombre de "J'aime" reçus</dt>
                    <dd><?php echo $user['totalrecieved'] ?></dd>
                </dl>

            </article>
        </main>
    </div>
</body>

</html>