<?php
require_once 'data_base_connexion.php';
session_start();

// Récupérer les données du formulaire d'inscription
$nameEnterprise= 'Aprogim';
var_dump($nameEnterprise);

// Première requête SQL
// Récupérer l'ID de l'entreprise
$sql1 = "SELECT ID_Entreprise FROM entreprise WHERE nom LIKE CONCAT('%', ?, '%')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('s', $nameEnterprise);
$stmt1->execute();
$result= $stmt1->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $ID_Entreprise = $row['ID_Entreprise'];
    var_dump($ID_Entreprise);
}

else
{
    echo "L'entreprise n'existe pas dans la base de données.";
}
$stmt1->close();

// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Supprimer les évaluations
$sql2 = "DELETE FROM evaluer WHERE id_entreprise=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $ID_Entreprise);

if ($stmt2->execute()) {
    echo "evaluation supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppression de l'eval : " . $conn->error;
}
$stmt2->close();

// Supprimer l'entreprise
$sql3 = "DELETE FROM entreprise WHERE id_entreprise=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('i', $ID_Entreprise);

if ($stmt3->execute()) {
    echo "Entreprise supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppression de l'entreprise : " . $conn->error;
}
$stmt3->close();

