<?php
require_once 'data_base_connexion.php';

$recherche = $_POST['search'];
$type = $_POST['quietesvous'];
$secteur = $_POST['secteur'];
$ville = $_POST['ville'];
$duree = $_POST['duree'];
$publication = $_POST['publication'];

$sql = "$sql = "SELECT *
        FROM entreprise
        JOIN adresse ON entreprise.ID_Adresse = adresse.ID_Adresse
        JOIN offre ON offre.ID_Entreprise = entreprise.ID_Entreprise
        JOIN connaitre ON connaitre.ID_Offre = offre.ID_Offre
        JOIN competence ON connaitre.ID_Competence = competence.ID_Competence
        WHERE
        entreprise.nom LIKE '%$recherche%' AND
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