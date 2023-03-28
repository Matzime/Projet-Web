<?php
require_once 'data_base_connexion.php';

$competence = $_POST['competence'];
$entreprise = $_POST['entreprise'];
$duree = $_POST['duree'];
$ville = $_POST['ville'];
$publication = $_POST['publication'];


if($duree==1){$dureeBis='< 8';}
if($duree==2){$dureeBis='BETWEEN 8 AND 16';}
if($duree==3){$dureeBis='BETWEEN 16 AND 24';}
if($duree==4){$dureeBis='> 24';}

if($publication){
    $publicationBis='ORDER BY Date_Offre';}
    else{$publicationBis='ORDER BY Date_Offre DESC';}

$sql = "SELECT *
FROM entreprise
JOIN adresse ON entreprise.ID_Adresse = adresse.ID_Adresse
JOIN offre ON offre.ID_Entreprise = entreprise.ID_Entreprise
JOIN connaitre ON connaitre.ID_Offre = offre.ID_Offre
JOIN competence ON connaitre.ID_Competence = competence.ID_Competence
WHERE
(entreprise.Nom LIKE '%$entreprise%' OR '$entreprise' = '') AND
(competence.Competence = '$competence' OR '$competence' = '') AND
(Duree_offre $dureeBis) AND
(Nom_Ville = '$ville' OR '$ville' = '') AND
(Date_Offre = '$publication' OR '$publication' = '') $publicationBis";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "/////////////////////////////////////////////////////////////// " . "<br>";
        echo "Nature du poste : " . $row['Competence'] . "<br>";
        echo "Entreprise : " . $row['Nom'] . "<br>";
        echo "Ville : " . $row['Nom_Ville'] . "<br>";
        echo "Date de publication : " . $row['Date_Offre'] . "<br>";
        echo "Nombre de places : " . $row['Nbr_Places_Offre'] . "<br>";
        echo "Base de rémunération : " . $row['Remuneration_Offre'] . "<br>";
        echo "Durée : " . $row['Duree_offre'] . "<br><br>";
    }
} else {
    echo "Aucune offre trouvée.";
}
?>