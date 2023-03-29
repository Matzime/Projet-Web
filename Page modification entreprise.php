<?php
require_once 'data_base_connexion.php';
$nameEnterprise = isset($_POST['entreprise']) ? $_POST['entreprise'] : '';
$competence = isset($_POST['secteur_act']) ? $_POST['secteur_act'] : '';
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
$evaluation = isset($_POST['confiance_pilote']) ? $_POST['confiance_pilote'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page modification entreprise.css">
    <meta charset="UTF-8" />
    <title>Modifie ton entreprise</title>
</head>

<body>
    <header>
        <nav class="menu">
        <div class="m-left">
            <a href="accueil.html"><img class="logo" src="image/logo.png" alt="logo" class="logo"/></a>
        </div>

        <div class="m-right">
            <form method="post" action="logout.php">
                <button type="submit" name="logout" style="background:none;border:none;">
                    <img class="m-logo1" src="image/Profil.png" alt="logoprofil" >
                </button>
                <button style="background:none;border:none;">
                    <img class="m-logo2" src=image/Bell.png alt="logobell">
                </button>
            </form>
        </div>

        </nav>
        <div class="yellowbar">
        </div>
    </header>

    <main>
        <section style="align-items: center;text-align: center;">
                <div class="text">
                    <h1><?php echo $nameEnterprise ?></h1>
                </div>
            <div class="profil">
                <img src="./image/Profil.png" class="phprof" alt="profil"/>
            </div>
        </section>
        <div>
            <h2>Informations :</h2>
        </div>
        <form action="update_entreprise.php">
        <section class ="cadrejaunerech">
            <div class="image"><img src="./image/gear.png" alt="mail" class="png" /></div>
            <div class="text">
                <input type="text" name="secteur_act"/>
            </div>
            <div class="image"><img src="./image/marker.png" alt="mail" class="png" /></div>
            <div class="text">
                <input type="text" name="adresse"/>
            </div>
            <div class="image"><img src="./image/star.png" alt="mail" class="png" /></div>
            <div class="text">
                <input type="number" name="confiance_pilote"/>
            </div>
        </section>
        <section style="align-items: center;text-align: center;">        
            <button class="buttonsub" type="submit"><b>Annuler</b></button>
            <form action="update_entreprise.php" method="post">
            <input type="hidden" name="entreprise" value="<?php echo htmlspecialchars($nameEnterprise); ?>">
            <input type="hidden" name="secteur_act" value="<?php echo htmlspecialchars($competence); ?>">
            <input type="hidden" name="adresse" value="<?php echo htmlspecialchars($adresse); ?>">
            <input type="hidden" name="confiance_pilote" value="<?php echo htmlspecialchars($evaluation); ?>">
                <button class="buttonsub" type="submit"><b>Valider</b></button>
            </form>
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