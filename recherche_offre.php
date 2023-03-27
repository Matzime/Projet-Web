<?php
require_once 'connexion.php';

$recherche = $_POST['search'];
$type = $_POST['quietesvous'];
$secteur = $_POST['secteur'];
$ville = $_POST['ville'];
$duree = $_POST['duree'];
$publication = $_POST['publication'];

$sql = "SELECT * FROM offres WHERE
        titre LIKE '%$recherche%' AND
        type = '$type' AND
        secteur = '$secteur' AND
        ville = '$ville' AND
        duree = '$duree' AND
        publication = '$publication'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Nom du poste : " . $row['titre'] . "<br>";
        echo "Entreprise : " . $row['secteur'] . "<br>";
        echo "Domaine : " . $row['ville'] . "<br>";
        echo "Domaine : " . $row['publication'] . "<br>";
        echo "Adresse : " . $row['duree'] . "<br><br>";
    }
} else {
    echo "Aucune offre trouvée.";
}
?>