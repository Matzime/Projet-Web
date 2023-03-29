<?php
require_once 'data_base_connexion.php';
session_start();

// Récupérer les données du formulaire d'inscription
$nom_entreprise = isset($_POST['entreprise']) ? $_POST['entreprise'] : '';;
$secteur = isset($_POST['competence']) ? $_POST['competence'] : '';;
$confiance_pilote = isset($_POST['confiance_pilote']) ? $_POST['confiance_pilote'] : '';;
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';;


//Récupération, décomposition et validation de l'adresse
$adresse = urlencode('7 Rue De Létoile du matin Saint-Nazaire 44380'); // Encodage de l'adresse pour la requête
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

// Récupérer l'ID de l'entreprise
$sql4 = "SELECT ID_Entreprise FROM entreprise WHERE nom LIKE CONCAT('%', ?, '%')";
$stmt4 = $conn->prepare($sql4);
$stmt4->bind_param('s', $nom_entreprise);
$stmt4->execute();
$result= $stmt4->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $ID_entreprise = $row['ID_Entreprise'];
    var_dump($ID_entreprise);
}


// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Récupérer l'ID de l'adresse
$sql5 = "SELECT ID_Adresse FROM entreprise WHERE id_entreprise =?";
$stmt5 = $conn->prepare($sql5);
$stmt5->bind_param('i', $ID_entreprise);
$stmt5->execute();
$result= $stmt5->get_result();

if ($result->num_rows > 0) 
{
    $row = $result->fetch_assoc();
    $ID_adresse= $row['ID_Adresse'];
    var_dump($ID_adresse);
}

// Update adresse
$sql1 = "UPDATE adresse SET Num_rue=?, Nom_rue=?, Nom_ville=?, CP_Ville=? WHERE ID_Adresse=?";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('issii', $numero, $rue, $ville, $code_postal, $ID_adresse);

if ($stmt1->execute()) {
    echo "Adresse modifié avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'adresse : " . $conn->error;
}
$stmt1->close();

// Récupérer ID Compétence
$stmt = $conn->prepare("SELECT ID_Competence, Competence FROM competence WHERE Competence LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $secteur);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // La compétence existe déjà, récupérer son ID
    $row = $result->fetch_assoc();
    $ID_Competence = $row['ID_Competence'];
} else {
    // La compétence n'existe pas, insérer une nouvelle compétence et récupérer son ID
    $stmt = $conn->prepare("INSERT INTO competence (Competence) VALUES (?)");
    $stmt->bind_param("s", $secteur);
    $stmt->execute();
    $ID_Competence = $stmt->insert_id;
}

// modification de l'entreprise
$sql2 = "UPDATE entreprise SET ID_Competence=?, ID_Adresse=?
WHERE ID_Entreprise=?";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('iii', $ID_Competence, $ID_adresse, $ID_entreprise);

if ($stmt2->execute()) {
    echo "Entreprise modifé avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'entreprise : " . $conn->error;
}
$stmt2->close();

// modification evaluation
$sql3 = "UPDATE evaluer SET ID_Utilisateur=?, Evaluation=?
WHERE ID_Entreprise=?";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('iii', $userID, $confiance_pilote, $ID_entreprise);

if ($stmt3->execute()) {
    echo "Evalutation modifié avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'évaluation : " . $conn->error;
}
$stmt3->close();
?>

