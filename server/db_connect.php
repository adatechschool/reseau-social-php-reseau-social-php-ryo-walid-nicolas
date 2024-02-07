<?php
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
if ($mysqli->connect_errno)
{
    echo("Échec de la connexion : " . $mysqli->connect_error);
    exit();
}

// Check if 'user_id' is set in $_GET and cast it to an integer, otherwise default to null
$userId = isset($_GET['user_id']) ? intval($_GET['user_id']) : null;

// Check if 'tag_id' is set in $_GET and cast it to an integer, otherwise default to null
$tagId = isset($_GET['tag_id']) ? intval($_GET['tag_id']) : null;

function checkQueryResult($tocheck, $mysqli) {
    if (!$tocheck) {
        echo("Échec de la requête : " . $mysqli->error);
        exit();
    }
}

?>