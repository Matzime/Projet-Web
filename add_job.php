<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$entreprise = $_POST['enterprise'];
$salary = $_POST['salary'];
$period = $_POST['period'];
$seats = $_POST['seats'];
$skill = $_POST['skill'];


//Récupération, décomposition et validation de l'adresse
$address = urlencode($_POST['address']); // Encodage de l'adresse pour la requête
$apiKey = 'f7506853d19a4b5e9fa3382af20257f8'; 

// Effectuer une requête HTTP vers l'API Geocoding
$url = "https://api.opencagedata.com/geocode/v1/json?q={$address}&key={$apiKey}";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

// Décoder la réponse JSON
$responseData = json_decode($response, true);

if (isset($responseData['results'][0])) {
    $addressDetails = $responseData['results'][0]['components'];

    $road = $addressDetails['road'] ?? '';
    $number = $addressDetails['house_number'] ?? '';
    $town = $addressDetails['town'] ?? $addressDetails['city'] ?? '';
    $postCode = $addressDetails['postcode'] ?? '';

} else {
    echo "Adresse introuvable. Veuillez vérifier l'adresse saisie.";
}

//on génère un nombre aléatoire pour l'ID_Adresse et l'ID_Offre
$min = 10;
$max = 1000000; // Vous pouvez définir la valeur maximale que vous souhaitez
$randomNumber = mt_rand($min, $max);

$ID_address=$randomNumber;
$ID_Offre=$randomNumber;

// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Première requête SQL
$sql1 = "INSERT INTO adresse (ID_Adresse, Num_rue, Nom_rue, Nom_ville, CP_Ville) VALUES (?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('iissi', $ID_address, $number, $road, $town, $postCode);

if ($stmt1->execute()) {
    echo "Adresse ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'adresse : " . $conn->error;
}
$stmt1->close();

// Deuxième requête SQL
$sql2 = "INSERT INTO offre (ID_offre, Duree_Offre, Remuneration_Offre, Date_Offre, Nbr_Places_Offre, ID_Entreprise) 
VALUES (?, ?, ?, ?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param('isi', $ID_enterprise, $nom_enterprise, $ID_address);

if ($stmt2->execute()) {
    echo "Entreprise ajoutée avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'entreprise : " . $conn->error;
}
$stmt2->close();

// troisième requête SQL
$sql3 = "INSERT INTO evaluer (ID_Entreprise, ID_Utilisateur, Evaluation) VALUES (?, ?, ?)";
$stmt3 = $conn->prepare($sql3);
$stmt3->bind_param('iii', $ID_enterprise, $_SESSION['user_id'], $trustPilot);

if ($stmt3->execute()) {
    echo "Evalutation ajouté avec succès.";
} else {
    echo "Une erreur est survenue lors de l'ajout de l'évaluation : " . $conn->error;
}
$stmt3->close();

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

// Mettre à jour l'entreprise avec l'ID de la compétence
$stmt = $conn->prepare("UPDATE entreprise SET ID_Competence = ? WHERE ID_Entreprise = ?");
$stmt->bind_param("ii", $ID_Competence, $ID_entreprise);
$stmt->execute();

?>

