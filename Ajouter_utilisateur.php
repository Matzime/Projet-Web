
<?php
require_once 'connexion.php';

// Récupérer les données du formulaire d'inscription
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$passwordVerif = $_POST['passwordVerif'];

// Chiffrer le mot de passe (s'il a bien été répété deux fois)
    if($password==$passwordVerif){
$motdepasse_chiffre = password_hash($password, PASSWORD_DEFAULT);}

// Préparer la requête SQL pour ajouter l'utilisateur
$sql = "INSERT INTO utilisateur (prenom, nom, mail, motdepasse_chiffre) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nom, $email, $motdepasse_chiffre);

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