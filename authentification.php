<?php
require_once 'connexion.php';

$Mail = $_POST['login'];
$MDP = $_POST['password'];

// Préparer la requête SQL
$sql = "SELECT * FROM utilisateur WHERE Mail = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $Mail);

// Exécuter la requête
$stmt->execute();

$result = $stmt->get_result();

// Vérifier si l'utilisateur existe
if ($result->num_rows > 0) {
    // Récupérer les données de l'utilisateur
    $user = $result->fetch_assoc();

    // Vérifier le mot de passe
    if ($MDP == $user['MDP']) {
        // Les identifiants sont corrects
        echo "Connexion réussie. Bienvenue, " . $user['Mail'] . "!";
        // Vérifiez si la case "Se souvenir de moi" a été cochée
    if (isset($_POST['remember_me'])) {
        // Créez des cookies pour stocker les informations d'authentification
        setcookie('user_email', $user['Mail'], time() + (86400 * 30), "/"); // Stocke l'e-mail pendant 30 jours
        setcookie('user_password', $MDP, time() + (86400 * 30), "/"); // Stocke le Mot de passe pendant 30 jours
    }} else {
        // Le mot de passe est incorrect
        echo "Erreur : mot de passe incorrect.";
}}
?>