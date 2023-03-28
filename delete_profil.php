<?php
require_once 'data_base_connexion.php';
session_start();

// Récupérer les données du formulaire d'inscription
$fstName= 'Maxime';
$sndName= 'Guniard';
var_dump($fstName);
var_dump($sndName);

// Première requête SQL
// Récupérer l'ID de l'utilisateur
$sql1 = "SELECT ID_utilisateur FROM utilisateur WHERE prenom LIKE CONCAT('%', ?, '%') AND nom LIKE CONCAT('%', ?, '%')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ss', $fstName, $sndName);
$stmt1->execute();
$result= $stmt1->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $ID_user = $row['ID_utilisateur'];
    var_dump($ID_user);
}
else
{
    echo "L'utilisateur n'existe pas dans la base de données.";
}
$stmt1->close();

// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Supprimer l'utilisateur des évaluations
$sql2 = "DELETE FROM evaluer WHERE id_utilisateur=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $ID_user);

if ($stmt2->execute()) {
    echo "evaluation supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppression de l'eval : " . $conn->error;
}
$stmt2->close();

// Troisième requête SQL
// Supprimer l'utilisateur de la wishlist
$sql3 = "DELETE FROM Souhaiter WHERE id_utilisateur=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('i', $ID_user);

if ($stmt3->execute()) {
    echo "Offre supprimer de la wishlist avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion des candidatures : " . $conn->error;
}
$stmt3->close();

// Supprimer l'utilisateur des candiature
$sql4 = "DELETE FROM Connaitre WHERE id_utilisateur=?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('i', $ID_user);

if ($stmt3->execute()) {
    echo "Connaitre supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion des candidatures : " . $conn->error;
}
$stmt4->close();

// Supprimer l'utilisateur des candiature
$sql5 = "DELETE FROM Utilisateur WHERE id_utilisateur=?";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('i', $ID_user);

if ($stmt3->execute()) {
    echo "Utilisateur supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion des candidatures : " . $conn->error;
}
$stmt4->close();
?>
?>
