<?php
require_once 'data_base_connexion.php';
// Démarrage de la session
session_start();
$ID_Offre = isset($_GET['offre_id']) ? $_GET['offre_id'] : 'Offre';

$sql = "SELECT *, entreprise.Nom AS Nom_Entreprise
FROM entreprise
JOIN adresse ON entreprise.ID_Adresse = adresse.ID_Adresse
JOIN offre ON offre.ID_Entreprise = entreprise.ID_Entreprise
JOIN connaitre ON connaitre.ID_Offre = offre.ID_Offre
JOIN competence ON connaitre.ID_Competence = competence.ID_Competence
WHERE
(offre.ID_Offre = '$ID_Offre');";


$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nomOffre = $row['Nom_Offre'];
        $enterprise = $row['Nom_Entreprise'];
        $money = $row['Remuneration_Offre'];
        $address = $row['Nom_Ville'];
        $period = $row['Duree_offre'];
        $datePublication = $row['Date_Offre'];
        $seats = $row['Nbr_Places_Offre'];
        $skill = $row['Competence'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page modification offre.css">
    <meta charset="UTF-8" />
    <title>Stage Xplorer</title>
</head>

<body>
    <header>
        <nav class="menu">
        <div class="m-left">
            <a href="accueil.html"><img class="logo" src="image/logo.png" alt="logo" class="logo"/></a>
        </div>
        <div class="m-right">
            <a href="#" class="m-logo1"><img src="image/Profil.png" alt="logoprofil"></a>
            <a href="#" class="m-logo2"><img src="image/Bell.png" alt="logonotif"> </a>
        </div>
        </nav>
        <div class="yellowbar">
        </div>
    </header>

    <main>
        <form action="update_job.php">
        <section style="align-items: center;text-align: center;">
                <div class="nomprenom">
                    <h1>Nom Offre</h1>
                </div>
        </section>
            <div>
                <h2>Informations :</h2>
            </div>
            <section class ="cadregris">
                <div class="image"><img src="./image/building.png" alt="mail" class="png" /></div>
                <div class="text">
                <input type="text" name="enterprise" value="<?php echo $nomOffre?>"/>
                </div>
                <div class="image"><img src="./image/money.png" alt="mail" class="png" /></div>
                <input type="number" class="nombre" name="salary" value="<?php echo $money?>"/>
                <p class="p">€<p>
                <div class="image"><img src="./image/marker.png" alt="mail" class="png" /></div>
                <div class="text">
                <input type="text" name="address" value="<?php echo $address?>"/>
                </div>
                <div class="image"><img src="./image/planning.png" alt="mail" class="png" /></div>
                <input type="number" class="nombre" name="period" value="<?php echo $period?>"/>
                <p class="p">Semaines</p>
                <div class="image"><img src="./image/people.png" alt="mail" class="png" /></div>
                <input type="number" class="nombre" name="seats" value="<?php echo $seats?>"/>
                <p></p>
                <div><h3>Compétences requises :</h3></div>
                <div class="text text2">
                    <input type="text" name="skill" value="<?php echo $skill?>"/>
                </div>
            </section>
            <section style="align-items: center;text-align: center;">        
                <button class="buttonsub" ><b>Annuler</b></button>
                <button class="buttonsub" type="submit"><b>Valider</b></button>
            </section>
        </form>
    </main>
    <footer class="footer">
        <div class="flex">
            <div class="margin" class="domaine" class="flex"> 
                <p class="titre" class="pfooter">DOMAINES</p>
                <p class="pfooter">BTP</p>
                <p class="pfooter">Industrie</p>
                <p class="pfooter">RH & Management</p>
                <p class="pfooter">Informatique & Numérique</p>
            </div>
            <div class="margin" class="information" class="flex">
                <p class="titre" class="pfooter">INFORMATIONS</p>
                <p class="pfooter"><a href="Mentions légales et Politique de confidentialité.html">Politique de confidentialitées</a></p>
                <p class="pfooter"><a href="Mentions légales et Politique de confidentialité.html">Mentions légales</a></p>
                <p class="pfooter"><a href="CGU.html">CGU</a></p>
            </div>
                <div class="margin" >
                <p class="titre" class="pfooter">L'ACTUALITÉ </p>
                <div class="center"><a class="plink" href="https://www.linkedin.com/school/cesi-officiel/">Linkdin</a></div>
                <div class="center"><a class="plink" href="https://mobile.twitter.com/cesi_officiel">Twitter</a></div>
                <div class="center"><a class="plink" href="https://m.facebook.com/CESIingenieurs/events/">Facebook</a></div>
                <div class="center"><a class="plink" href="https://www.instagram.com/cesi_officiel/?hl=fr">Instagram</a></div>
                <div class="center"><a class="plink" href="https://www.youtube.com/channel/UCWanyqUivV6rjbTABGFI8pA">Youtube</a></div>
            </div>
        </div>
    </footer>
</body>
</html>