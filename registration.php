<?php
include "./server/db_connect.php";
include "./server/queries.php";
include "./server/session_management.php";
?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>ReSoC - Inscription</title>
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
                <h2>Inscription</h2>
                <?php
                ini_set('display_errors',  1);
                ini_set('display_startup_errors',  1);
                error_reporting(E_ALL);

                echo "<pre>" . print_r($_POST, 1) . "</pre>";

                function handleFormSubmission($mysqli)
                {
                    if (isset($_POST['email'], $_POST['pseudo'], $_POST['motpasse'])) {
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];


                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);

                        // on crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                        $new_passwd = password_hash($new_passwd, PASSWORD_BCRYPT);

                        // Assuming $conn is your database connection
                        $checkQuery = "SELECT COUNT(*) FROM users WHERE alias = ?";
                        $stmt = $mysqli->prepare($checkQuery);
                        $stmt->bind_param('s', $new_alias);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $count = $result->fetch_row()[0];

                        if ($count ==  0) {
                            // Proceed with the insertion because the alias is unique
                            $insertQuery = "INSERT INTO users (email, password, alias) VALUES (?, ?, ?)";
                            $stmt = $mysqli->prepare($insertQuery);
                            $stmt->bind_param("sss", $new_email, $new_passwd, $new_alias);
                            $stmt->execute();
                            echo "Votre inscription est un succès : " . $new_alias;
                            echo " <a href='login.php'>Connectez-vous.</a>";

                        } else {
                            // Handle the case where the alias is not unique
                            echo "L'alias '{$new_alias}' est déjà utilisé.";
                        }

                        $stmt->close();
                    }
                }

                if (isset($mysqli)) {
                    handleFormSubmission($mysqli);
                } else {
                    echo "Database connection failed.";
                }

                ?>
                <!-- Ajouter CSRF token pour authentification du site -->
                <form action="registration.php" method="post">


                    <input type='hidden' name='???' value='achanger'>
                    <dl>
                        <dt><label for='pseudo'>Pseudo</label></dt>
                        <dd><input type='text' name='pseudo' placeholder="pseudo" required></dd>
                        <dt><label for='email'>E-Mail</label></dt>
                        <dd><input type='email' name='email' placeholder="example@example.com" required></dd>
                        <dt><label for='motpasse'>Mot de passe</label></dt>
                        <dd><input type='password' name='motpasse' placeholder="mot de passe" required></dd>
                    </dl>
                    <input type='submit'>
                </form>
            </article>
        </main>
    </div>
</body>

</html>