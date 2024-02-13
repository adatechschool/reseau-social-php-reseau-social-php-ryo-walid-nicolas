<?php
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php"
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Connexion</title>
    <meta name="author" content="nicotine189">
    <link rel="stylesheet" href="./client/css/style.css" />
</head>

<body>
    <?php include './client/header.php'; ?>

    <div id="wrapper">

        <aside>
            <h2>Présentation</h2>
            <p>Bienvenu sur notre réseau social.</p>
        </aside>
        <main>
            <article>
                <h2>Connexion</h2>
                <?php

                // Formulaire de login
                $enCoursDeTraitement = isset($_POST['email']);
                if ($enCoursDeTraitement) {

                    // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                    $emailAVerifier = $_POST['email'];
                    $passwdAVerifier = $_POST['motpasse'];

                    // Sécu pour injection SQL
                    $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                    $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);

                    // Hashage du mot de passe selon la même méthode que lors de la registration 
                    $options = ['cost' =>  12]; // Cost factor for bcrypt
                    $hashed_password = password_hash($passwdAVerifier, PASSWORD_BCRYPT, $options);

                    // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité
                    //Etape 5 : construction de la requete
                    $lInstructionSql = "SELECT * "
                        . "FROM users "
                        . "WHERE "
                        . "email LIKE '" . $emailAVerifier . "'";

                    // Etape 6: Vérification de l'utilisateur
                    $res = $mysqli->query($lInstructionSql);
                    $user = $res->fetch_assoc();
                    if (!$user or $user["password"] != $passwdAVerifier) {
                        echo "La connexion a échouée. ";
                    } else {
                        echo "Votre connexion est un succès : " . $user['alias'] . ".";

                        // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                        // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                        $_SESSION['connected_id'] = $user['id'];
                    }
                }
                ?>
                <form action="login.php" method="post">
                    <input type='hidden' name='???' value='achanger'>
                    <dl>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email'></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse'></dd>
                    </dl>
                    <input type='submit'>
                </form>
                <p>
                    Pas de compte?
                    <a href='registration.php'>Inscrivez-vous.</a>
                </p>

            </article>
        </main>
    </div>
</body>

</html>