<?php
    session_start();
    if (isset($_POST['logout'])) {
// Détruire la session
session_unset();
session_destroy();

// Supprimer les cookies si vous les avez utilisés pour la fonction "Se souvenir de moi"
if (isset($_COOKIE['user_email']) && isset($_COOKIE['user_id'])) {
    setcookie("user_email", "", time() - 3600, "/"); // Expire le cookie
    setcookie("user_id", "", time() - 3600, "/"); // Expire le cookie
}

header("Location: connexion.html");
exit;
    }
?>