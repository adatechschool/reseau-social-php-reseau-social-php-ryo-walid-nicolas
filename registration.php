<?php 
include "./server/db_connect.php";
include "./server/queries.php";
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Inscription</title> 
        <meta name="author" content="nicotine189">
        <link rel="stylesheet" href="./client/css/style.css"/>
    </head>
    <body>
        <?php include './client/header.php';?>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenu sur notre réseau social.</p>
            </aside>
            <main>
                <article>
                    <h2>Inscription</h2>
                    <?php
                    /**
                     * TRAITEMENT DU FORMULAIRE
                     */
                    // Vérifier si les champs sont renseignés
                    $enCoursDeTraitement = isset($_POST['email']);
                    if ($enCoursDeTraitement)
                    {
                        // echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // récupère les champs du formulaire
                        $new_email = $_POST['email'];
                        $new_alias = $_POST['pseudo'];
                        $new_passwd = $_POST['motpasse'];
                        // Protection contre les injections SQL (échappe les caratères spéciaux)
                        $new_email = $mysqli->real_escape_string($new_email);
                        $new_alias = $mysqli->real_escape_string($new_alias);
                        $new_passwd = $mysqli->real_escape_string($new_passwd);
                        
                        // Hachage du password
                        $new_passwd = md5($new_passwd);

                        //Etape 5 : construction de la requete
                        $lInstructionSql = "INSERT INTO users (id, email, password, alias) "
                                . "VALUES (NULL, "
                                . "'" . $new_email . "', "
                                . "'" . $new_passwd . "', "
                                . "'" . $new_alias . "'"
                                . ");";
                        // Etape 6: exécution de la requete
                        $ok = $mysqli->query($lInstructionSql);
                        if ( ! $ok)
                        {
                            echo "L'inscription a échouée : " . $mysqli->error;
                        } else
                        {
                            echo "Votre inscription est un succès : " . $new_alias;
                            echo " <a href='login.php'>Connectez-vous.</a>";
                        }
                    }
                    ?>                     
                    <!-- Ajouter CSRF token pour authentification du site -->
                    <form action="registration.php" method="post">
                        <input type='hidden'name='???' value='achanger'>
                        <dl>
                            <dt><label for='pseudo'>Pseudo</label></dt>
                            <dd><input type='text'name='pseudo' placeholder="pseudo" required></dd>
                            <dt><label for='email'>E-Mail</label></dt>
                            <dd><input type='email'name='email' placeholder="example@example.com" required></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse' placeholder="mot de passe" required></dd>
                        </dl>
                        <input type='submit'>
                    </form>
                </article>
            </main>
        </div>
    </body>
</html>
