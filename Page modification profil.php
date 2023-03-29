<?php
require_once 'data_base_connexion.php';
$fstname = isset($_GET['prenom_recherché']) ? $_GET['prenom_recherché'] : 'Prénom';
$sndname = isset($_GET['nom_recherché']) ? $_GET['nom_recherché'] : 'Nom';
$role = isset($_GET['role']) ? $_GET['role'] : 'Role';

$sql = "SELECT * FROM utilisateur 
JOIN centre ON centre.ID_Centre = utilisateur.ID_Centre
JOIN appartenir ON appartenir.ID_Utilisateur = utilisateur.ID_Utilisateur
JOIN promo ON appartenir.ID_Promo = promo.ID_Promo Where SOUNDEX(Prenom) = SOUNDEX($fstname) AND SOUNDEX(Nom) = SOUNDEX($sndname);";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $promo = $row['Promo'];
    $mail = $row['Mail'];
    $campus = $row['Centre'];
} else {
    header("Location: accueil.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page modification profil.css">
    <meta charset="UTF-8" />
    <title>Modifie ton profil</title>
</head>

<body>
    <header>
        <nav class="menu">
        <div class="m-left">
            <a href="accueil.html"><img class="logo" src="image/logo.png" alt="logo" class="logo"/></a>
        </div>
        <div class="m-right">
            <a href="#" class="m-logo1"><img src="./image/Profil.png"></a>
            <a href="#" class="m-logo2"><img src="./image/Bell.png"></a>
        </div>

        </nav>
        <div class="yellowbar">
        </div>
    </header>

    <main>
        <section style="align-items: center;text-align: center;">
            <div class="text">
                <h1><?php echo $fstname.' '.$sndname?></h1>
            </div>
            <div class="profil">
                <img src="./image/Profil.png" alt="profil"/>
            </div>
            <form method="POST" action="logout.php">
            <div><button type="submit" name="logout" class="butdeco">SE DECONNECTER</button></div></form>
        </section>
        <section class ="cadrejaunerech">
            <div class="image"><img src="./image/mail.png" alt="mail" class="png" /></div>
            <div class="text"><input type="text"/></div>

            <div class="image"><img src="./image/badge.png" alt="mail" class="png" /></div>
            <div class="text" >                
            Promo :
            <select>
                <option><?php echo $promo?></option>
            </select>
        </div>

            <div class="image"><img src="./image/building.png" alt="mail" class="png" /></div>
            <div class="text" >
                Campus :
            <select>
                <option><?php echo $center?></option>				
            </select>
            </div>
        </section>
        <section style="align-items: center;text-align: center;">        
            <button class="buttonsub" type="submit">Annuler</button>
            <button class="buttonsub" type="submit">Valider</button>
        </section>
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