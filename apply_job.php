<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$nameJob = $_COOKIE['nameJob'];
$ID_user = $_COOKIE['user_id'];
$cv = $_COOKIE['cv'];
$letter = $_COOKIE['letter'];

//Récupération de la date d'aujourd'hui
$dateApply = date("d-m-Y");

// Récupérer l'ID du l'offre à partir du nom
$stmt = "SELECT ID_Offre FROM offre WHERE Nom_offre LIKE CONCAT('%', ?, '%')";
$stmt->bind_param("s", $nameJob);
$stmt->execute();
$result = $stmt->get_result();
$ID_job = $result;

// Préparer la requête SQL pour ajouter une évaluation
// Requête SQL
$sql1 = "INSERT INTO candidature (ID_Utilisateur, CV, Lettre_Motivation, Date_Candidature, ID_Statut, ID_Offre, ID_Utilisateur) 
VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ii', $ID_user, $cv, $letter, $dateApply, 1, $ID_job, $ID_user);

if ($stmt1->execute()) {
    echo "Votre candidature à bien été pris en compte.";
} else {
    echo "Une erreur est survenue lors de votre candidature. " . $conn->error;
}
$stmt1->close();
?>