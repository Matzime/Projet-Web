<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$nom_entreprise = $_POST['nom_entreprise'];
$secteur_act = $_POST['secteur_act'];
$confiance_pilote = $_POST['confiance_pilote'];

//Récupération, décomposition et validation de l'adresse
$adresse = urlencode($_POST['adresse']); // Encodage de l'adresse pour la requête
$apiKey = 'f7506853d19a4b5e9fa3382af20257f8'; 

// Effectuer une requête HTTP vers l'API Geocoding
$url = "https://api.opencagedata.com/geocode/v1/json?q={$adresse}&key={$apiKey}";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

// Décoder la réponse JSON
$responseData = json_decode($response, true);

if (isset($responseData['results'][0])) {
    $adresseDetails = $responseData['results'][0]['components'];

    $rue = $adresseDetails['road'] ?? '';
    $numero = $adresseDetails['house_number'] ?? '';
    $ville = $adresseDetails['town'] ?? $adresseDetails['city'] ?? '';
    $code_postal = $adresseDetails['postcode'] ?? '';

} else {
    echo "Adresse introuvable. Veuillez vérifier l'adresse saisie.";
}
//on génère un nombre aléatoire pour l'ID_Adresse et l'ID_entreprise
$min = 10;
$max = 1000000; // Vous pouvez définir la valeur maximale que vous souhaitez
$nombre_aleatoire = mt_rand($min, $max);

$ID_adresse=$nombre_aleatoire;
$ID_entreprise=$nombre_aleatoire;
// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Première requête SQL
$sql1 = "INSERT INTO adresse (ID_Adresse, Num_rue, Nom_rue, Nom_ville, CP_Ville) VALUES (?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('iissi', $ID_adresse, $numero, $rue, $ville, $code_postal);

if ($stmt1->execute()) {
    echo "Adresse ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'adresse : " . $conn->error;
}
$stmt1->close();

// Deuxième requête SQL
$sql2 = "INSERT INTO entreprise (ID_Entreprise, Nom, Secteur_Activite, ID_Adresse) VALUES (?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('issi', $ID_entreprise, $nom_entreprise, $secteur_act, $ID_adresse);

if ($stmt2->execute()) {
    echo "Entreprise ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'entreprise : " . $conn->error;
}

// Troisième requête SQL
$sql2 = "INSERT INTO evaluer (ID_Entreprise, Nom, Secteur_Activite, ID_Adresse) VALUES (?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('issii', $ID_entreprise, $nom_entreprise, $secteur_act, $ID_adresse);

if ($stmt2->execute()) {
    echo "Entreprise ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'entreprise : " . $conn->error;
}
$stmt2->close();

?>

