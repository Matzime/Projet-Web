<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$prenom = $_COOKIE['prenom'];
$nom = $_COOKIE['nom'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$passwordVerif = $_POST['passwordVerif'];
$role = $_POST['role'];

// Récupérer l'ID de l'offre
$sql1 = "SELECT ID_Utilisateur FROM utilisateur WHERE prenom LIKE CONCAT('%', ?, '%') AND nom LIKE CONCAT('%', ?, '%')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('ss', $fstName, $sndName);
$stmt1->execute();
$result= $stmt1->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $idUser = $row['ID_Utilisateur'];
    var_dump($ID_Job);
}

else
{
    echo "L'entreprise n'existe pas dans la base de données.";
}
$stmt1->close();

// Préparer la requête SQL pour ajouter l'utilisateur
$sql2 = "UPDATE utilisateur SET Prenom=?, Nom=?, Mail=?, MDP=?, ID_Role=?) WHERE ID_Utilisateur=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('ssssii', $prenom, $nom, $mail, $motdepasse_chiffre, $ID_role, $idUser);

// Exécuter la requête
if ($stmt2->execute()) {
    echo "Utilisateur ajouté avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'utilisateur : " . $conn->error;
}
$stmt2->close();

?>
