<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$nameEnterprise = $_COOKIE['nameEnterprise'];
$ID_user = $_COOKIE['user_id'];
$evaluation = $_POST['evaluation'];

// Récupérer l'ID du l'entreprise à partir du nom
$stmt = "SELECT ID_Entreprise FROM entreprise WHERE Nom_Entreprise LIKE CONCAT('%', ?, '%')";
$stmt->bind_param("s", $nameEnterprise);
$stmt->execute();
$result = $stmt->get_result();
$ID_enterprise = $result;

// Préparer la requête SQL pour ajouter une évaluation
// Requête SQL
$sql1 = "INSERT INTO evaluer (ID_Entreprise, ID_utilisateur, Evaluation) VALUES (?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('iii', $ID_enterprise, $ID_user, $evaluation);

if ($stmt1->execute()) {
    echo "Evaluation ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'évaluation: " . $conn->error;
}
$stmt1->close();
?>