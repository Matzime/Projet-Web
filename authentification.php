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
    if (password_verify($MDP, $user['MDP'])) {
        // Les identifiants sont corrects
        echo "Connexion réussie. Bienvenue, " . $user['Mail'] . "!";
    } else {
        // Le mot de passe est incorrect
        echo "Erreur : mot de passe incorrect.";
}}
?>