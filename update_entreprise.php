<?php
require_once 'data_base_connexion.php';
session_start();

// Récupérer les données du formulaire d'inscription
$nom_entreprise = $_COOKIE['nom_entreprise'];
$secteur = $_POST['secteur_act'];
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

// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Première requête SQL
$sql1 = "UPDATE adresse SET Num_rue='$numero', Nom_rue='$rue', Nom_ville='$ville', CP_Ville='$code_postal' 
WHERE ID_Adresse='$ID_Adresse')";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('issii', $numero, $rue, $ville, $code_postal, $ID_Adresse);

if ($stmt1->execute()) {
    echo "Adresse modifié avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'adresse : " . $conn->error;
}
$stmt1->close();

//Secteur d'activité (semblable à compétence), comparé pour voir si la competence existe déjà ou non
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

// Modification de l'entreprise
$sql2 = "UPDATE entreprise SET ID_Competence='$ID_Competence', ID_Adresse='$ID_adresse' 
WHERE ID_Entreprise='$ID_entreprise'";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('iii', $ID_Competence, $ID_adresse, $ID_entreprise);

if ($stmt2->execute()) {
    echo "Entreprise modifé avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'entreprise : " . $conn->error;
}
$stmt2->close();



// insertion evaluation
$sql3 = "UPDATE evaluer SET ID_Utilisateur='$_COOKIE['user_id']', Evaluation='$confiance_pilote' 
WHERE ID_Entreprise='$ID_entreprise'";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('iii', $_COOKIE['user_id'], $confiance_pilote, $ID_entreprise);

if ($stmt3->execute()) {
    echo "Evalutation ajouté avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'évaluation : " . $conn->error;
}
$stmt3->close();
?>

