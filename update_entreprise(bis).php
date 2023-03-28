<?php
require_once 'data_base_connexion.php';
session_start();

// Récupérer les données du formulaire de modification
$nom_entreprise = $_COOKIE['nom_entreprise'];
$secteur = $_POST['secteur_act'];
$adresse = $_POST['adresse'];
$confiance_pilote = $_POST['confiance_pilote'];

// Récupérer l'ID_Adresse et l'ID_entreprise de l'entreprise
$stmt = $conn->prepare("SELECT ID_Adresse, ID_Entreprise FROM entreprise WHERE Nom=?");
$stmt->bind_param("s", $nom_entreprise);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $ID_Adresse = $row['ID_Adresse'];
    $ID_entreprise = $row['ID_Entreprise'];
} else {
    echo "Entreprise introuvable. Veuillez vérifier le nom de l'entreprise.";
    exit();
}

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
    exit();
}

// Modifier l'adresse
$sql1 = "UPDATE adresse SET Num_rue=?, Nom_rue=?, Nom_ville=?, CP_Ville=? WHERE ID_Adresse=?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('issii', $numero, $rue, $ville, $code_postal, $ID_Adresse);

if ($stmt1->execute()) {
    echo "Adresse modifiée avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'adresse : " . $conn->error;
}
$stmt1->close();

// Modifier l'entreprise
$sql2 = "UPDATE entreprise SET Secteur_activite=?, Confiance_pilote=? WHERE ID_Entreprise=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('sii', $secteur, $confiance_pilote, $ID_entreprise);

if ($stmt2->execute()) {
    echo "Entreprise modifiée avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'entreprise : " . $conn->error;
}
$stmt2->close();
?>
