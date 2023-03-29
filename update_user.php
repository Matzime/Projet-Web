<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$fstName = 'Maxime';
$sndName = 'Guniard';
$mail = 'dr@cesi.fr';
$password = 'oui';
$passwordVerif = 'oui';
$promo = 'CPIA1';
$campus= 'Paris';

// Récupérer l'ID de l'utilisateur
$sql1 = "SELECT ID_Utilisateur FROM utilisateur WHERE Prenom LIKE CONCAT('%', ?, '%') AND Nom LIKE CONCAT('%', ?, '%')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ss', $fstName, $sndName);
$stmt1->execute();
$result= $stmt1->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $idUser = $row['ID_Utilisateur'];
    var_dump($idUser);
}

else
{
    echo "Impossible Récupérer l'ID de l'utilisateur.";
}
$stmt1->close();

// Récupérer l'ID du centre
$sql2 = "SELECT ID_Centre FROM utilisateur WHERE prenom LIKE CONCAT('%', ?, '%') AND nom LIKE CONCAT('%', ?, '%')";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('ss', $fstName, $sndName);
$stmt2->execute();
$result= $stmt2->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $idCentre = $row['ID_Centre'];
    var_dump($idCentre);
}

else
{
    echo "Impossible Récupérer l'ID du centre";
}
$stmt2->close();

// Récupérer l'ID de la promo
$sql3 = "SELECT ID_Promo FROM Appartenir WHERE id_utilisateur LIKE CONCAT('%', ?, '%')";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('i', $idUser);
$stmt3->execute();
$result= $stmt3->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $idPromo = $row['ID_Promo'];
    var_dump($idPromo);
}

else
{
    echo "Impossible Récupérer l'ID de la promo";
}
$stmt3->close();

// Préparer la requête SQL pour ajouter l'utilisateur
// Changer info utilisateur
$sql4 = "UPDATE utilisateur SET Mail=?, MDP=?, ID_Centre=? WHERE ID_Utilisateur=?";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('ssii', $mail, $motdepasse_chiffre, $idCentre, $idUser);

// Exécuter la requête
if ($stmt4->execute()) {
    echo "Changer info utilisateur";
} else {
    echo "Impossible Changer info utilisateur : " . $conn->error;
}
$stmt4->close();

// Changer info promo
$sql5 = "UPDATE appartenir SET ID_Promo=? WHERE ID_Utilisateur=?";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('ii', $idPromo, $idUser);

// Exécuter la requête
if ($stmt5->execute()) {
    echo "Changer info promo";
} else {
    echo "Impossible Changer Changer info promo : " . $conn->error;
}
$stmt5->close();

?>