<?php
require_once 'connexion.php';

// Récupérer les données du formulaire d'inscription
$nom_entreprise = $_POST['nom_entreprise'];
$secteur_act = $_POST['secteur_act'];
$adresse = $_POST['adresse'];
$confiance = $_POST['confiance'];

// Préparer la requête SQL pour ajouter l'utilisateur
$sql = "INSERT INTO utilisateur (Prenom, Nom, Mail, MDP, ID_Role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $nom_entreprise, $secteur_act, $adresse, $confiance);

// Exécuter la requête
if ($stmt->execute()) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'utilisateur : " . $conn->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>