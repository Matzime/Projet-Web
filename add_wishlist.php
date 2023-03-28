<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$nameJob = $_COOKIE['nameJob'];
$ID_user = $_COOKIE['user_id'];

// Récupérer l'ID du l'entreprise à partir du nom
$stmt = "SELECT ID_Offre FROM offre WHERE Nom_offre LIKE CONCAT('%', ?, '%')";
$stmt->bind_param("s", $nameJob);
$stmt->execute();
$result = $stmt->get_result();
$ID_job = $result;

// Préparer la requête SQL pour ajouter une évaluation
// Requête SQL
$sql1 = "INSERT INTO souhaiter (ID_Utilisateur, ID_Offre) VALUES (?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ii', $ID_user, $ID_job,);

if ($stmt1->execute()) {
    echo "Offre ajoutée à la wish-list.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'offre à la wish-list. " . $conn->error;
}
$stmt1->close();
?>