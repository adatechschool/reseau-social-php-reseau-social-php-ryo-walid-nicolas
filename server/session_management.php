<?php
session_start();

// Store the initial values for comparison
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] >  3600) {
    // Session started more than an hour ago, destroy it and start a new one
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    // $_SESSION = array();           // unset session variables
    $_SESSION['CREATED'] = time();  // reset creation time
}

// Check the user agent
if (!isset($_SESSION['USER_AGENT'])) {
    $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
} else if ($_SESSION['USER_AGENT'] !== $_SERVER['HTTP_USER_AGENT']) {
    // The user agent has changed, destroy the session
    session_destroy();
    die('User agent mismatch.');
}

// Check the IP address
if (!isset($_SESSION['IP_ADDRESS'])) {
    $_SESSION['IP_ADDRESS'] = $_SERVER['REMOTE_ADDR'];
} else if ($_SESSION['IP_ADDRESS'] !== $_SERVER['REMOTE_ADDR']) {
    // The IP address has changed, destroy the session
    session_destroy();
    die('IP address mismatch.');
}
