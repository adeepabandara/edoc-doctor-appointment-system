<?php 
session_start();

// Regenerate the session ID after a successful login
session_regenerate_id(true);

$_SESSION = array();

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
}

session_destroy();

// Redirecting the user to the login page
header('Location: login.php?action=logout');

?>
