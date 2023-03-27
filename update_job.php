<?php
require_once 'data_base_connexion.php';

// Récupérer les données du formulaire d'inscription
$enterprise = $_POST['enterprise'];
$salary = $_POST['salary'];
$period = $_POST['period'];
$seats = $_POST['seats'];
$skill = $_POST['skill'];

//Récupération, décomposition et validation de l'adresse
$address = urlencode($_POST['address']); // Encodage de l'adresse pour la requête
$apiKey = 'f7506853d19a4b5e9fa3382af20257f8'; 

//Récupération de la date d'aujourd'hui
$datePublication = date("Y-m-d");

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

// Préparer la requête SQL pour ajouter l'entreprise et son adresse
// Première requête SQL
$sql1 = "UPDATE adresse (ID_Adresse, Num_rue, Nom_rue, Nom_ville, CP_Ville) 
VALUES (?, ?, ?, ?, ?) WHERE ID_adresse =[...]";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param('iissi', $ID_address, $number, $road, $town, $postCode);

if ($stmt1->execute()) {
    echo "Adresse modifié avec succès.";
} else {
    echo "Une erreur est survenue lors de la modification de l'adresse : " . $conn->error;
}
$stmt1->close();

// Deuxième requête SQL
//Vérifier si l'entreprise existe
$stmt = $conn->prepare("SELECT ID_Entreprise FROM entreprise WHERE nom LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $enterprise);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // L'entreprise existe déjà, récupérer son ID
    $row = $result->fetch_assoc();
    $ID_enterprise = $row['ID_Entreprise'];

    // Préparer la requête SQL pour ajouter l'offre
    $sql2 = "UPDATE offre (ID_offre, Duree_Offre, Remuneration_Offre, Date_Offre, Nbr_Places_Offre, ID_Entreprise) 
    VALUES (?, ?, ?, ?, ?, ?) WHERE ID_offre =[...]";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('ididii', $ID_job, $period, $salary, $datePublication, $seats, $ID_enterprise);

    if ($stmt2->execute()) {
        echo "Offre modifié avec succès.";
    } else {
        echo "Une erreur est survenue lors de la modification de l'offre : " . $conn->error;
    }
    $stmt2->close();
} else {
    // L'entreprise n'existe pas, afficher un message d'erreur
    echo "L'entreprise n'existe pas dans la base de données.";
    exit(); // arrête l'exécution du script
}

// troisième requête SQL
//Vérifier si la compétence existe
$stmt = $conn->prepare("SELECT ID_Competence FROM competence WHERE Competence LIKE CONCAT('%', ?, '%')");
$stmt->bind_param("s", $skill);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // La competence existe déjà, récupérer son ID
    $row = $result->fetch_assoc();
    $ID_skill = $row['ID_Competence'];

    // Préparer la requête SQL pour ajouter l'offre
    $sql3 = "UPDATE connaitre (ID_Connaitre, ID_Competence, ID_offre) VALUES (?, ?) WHERE ID_Connaitre =[...]";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param('ii',$ID_know, $ID_skill, $ID_job);

    if ($stmt3->execute()) {
        echo "Competence modifié avec succès.";

    } else {
        echo "Une erreur est survenue lors de la modfication de la competence : " . $conn->error;
    }
    $stmt->close();
} else {
    // La competence n'existe pas, afficher un message d'erreur
    echo "La competence n'existe pas dans la base de données.";
    exit(); // arrête l'exécution du script
}

?>