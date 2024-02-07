<?php 
include "./server/db_connect.php";
include "./server/queries.php";
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Mes abonnements</title> 
        <meta name="author" content="nicotine189">
        <link rel="stylesheet" href="./client/css/style.css"/>
    </head>
    <body>
        <?php include './client/header.php';?>

            <div id="wrapper">
            <aside>
                <img src="./client/img/user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez la liste des personnes dont
                        l'utilisatrice
                        n° <?php echo $userId ?>
                        suit les messages
                    </p>

                </section>
            </aside>
            <main class='contacts'>
                <?php
                $lesInformations = $mysqli->query($SQL_Subs);

                while ($subscribed = $lesInformations->fetch_assoc())
                {
                // echo "<pre>" . print_r($subscribed, 1) . "</pre>";
                ?>
                <article>
                    <img src="./client/img/user.jpg" alt="blason"/>
                    <h3><?php echo $subscribed['alias'] ?></h3>
                    <p>id:<?php echo $subscribed['id'] ?></p>                    
                </article>
                <?php
                }
                ?>
            </main>
        </div>
    </body>
</html>
