
<?php
require_once 'connexion.php';

// Récupérer les données du formulaire d'inscription
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$mail = $_POST['mail'];
$password = $_POST['password'];
$passwordVerif = $_POST['passwordVerif'];
$role = $_POST['role'];

// Chiffrer le mot de passe (s'il a bien été répété deux fois)
    if($password==$passwordVerif){
$motdepasse_chiffre = password_hash($password, PASSWORD_DEFAULT);}

// Déterminer l'ID du role choisie (pour préparer jointure table utilisateur-role)
if($role=="Pilote"){$ID_role=2;}
else{$ID_role=3;}


// Préparer la requête SQL pour ajouter l'utilisateur
$sql = "INSERT INTO utilisateur (Prenom, Nom, Mail, MDP, ID_Role) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ssssi', $prenom, $nom, $mail, $motdepasse_chiffre, $ID_role);

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