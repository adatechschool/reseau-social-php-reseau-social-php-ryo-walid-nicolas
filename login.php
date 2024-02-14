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

                    // Requête pour récupérer le hash du profil
                    $lInstructionSql = "SELECT * "
                        . "FROM users "
                        . "WHERE "
                        . "email LIKE '" . $emailAVerifier . "'";

                    // Vérification de l'utilisateur
                    $res = $mysqli->query($lInstructionSql);
                    $user = $res->fetch_assoc();
                    $userPassword = $user["password"];

                    // Verifying a password : utilisation de password_verify (pas besoin de hasher, la fonction hashe la mdp avant de le comparer)
                    if (password_verify($passwdAVerifier, $userPassword)) {
                        echo "Connexion successful";
                    } else {
                        echo 'commentaire TBC';
                    }
                    $_SESSION['connected_id'] = $user['id'];
                    echo $_SESSION['connected_id'];
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