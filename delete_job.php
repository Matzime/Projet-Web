<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$nameJob = 'Offre1';
var_dump($nameJob);

// Première requête SQL
// Récupérer l'ID de l'offre
$sql1 = "SELECT ID_Offre FROM offre WHERE nom_offre LIKE CONCAT('%', ?, '%')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('s', $nameJob);
$stmt1->execute();
$result= $stmt1->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $ID_Job = $row['ID_Offre'];
    var_dump($ID_Job);
}

else
{
    echo "L'entreprise n'existe pas dans la base de données.";
}

// Deuxième requête SQL
// Supprimer l'offre des candiature
$sql2 = "DELETE FROM Candidature WHERE id_offre=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('i', $ID_Job);

if ($stmt2->execute()) {
    echo "Candidatures supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion des candidatures : " . $conn->error;
}
$stmt2->close();

// Troisième requête SQL
// Supprimer l'offre des candiature
$sql3 = "DELETE FROM Connaitre WHERE id_offre=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('i', $ID_Job);

if ($stmt3->execute()) {
    echo "Compétence supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion des candidatures : " . $conn->error;
}
$stmt3->close();

// Troisième requête SQL
// Supprimer l'offre de la wishlist
$sql5 = "DELETE FROM Souhaiter WHERE id_offre=?";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('i', $ID_Job);

if ($stmt3->execute()) {
    echo "Offre supprimer de la wishlist avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion dans la wishlist : " . $conn->error;
}
$stmt5->close();

// Quatrième requête SQL
// Supprimer l'offre
$sql4 = "DELETE FROM offre WHERE id_offre=?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('i', $ID_Job);

if ($stmt4->execute()) {
    echo "Offre supprimer avec succès.";
} else {
    echo "Une erreur est survenue lors de la suppresion de l'offre : " . $conn->error;
}
$stmt4->close();

?>