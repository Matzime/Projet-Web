<?php
$nameEnterprise = "Nom Entreprise"; // Remplacez "Nom Offre" par la valeur que vous souhaitez stocker dans le cookie
setcookie("nameEnterprise", $nameEnterprise, time() + 3600, "/"); // Créer un cookie nommé "nom_offre" avec une durée de vie de 1 heure
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page présentation entreprise.css">
    <meta charset="UTF-8" />
    <title>Entreprise</title>
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
            <div class="nomprenom">
                <h1><?php$nameEnterprise?></h1>
            </div>
            <div class="profil">
                <img src="./image/Profil.png" alt="profil"/>
            </div>
        </section>
        <div>
            <h2>Informations :</h2>
        </div>
        <section class ="cadregris">
            <div class="image"><img src="./image/gear.png" alt="mail" class="png" /></div>
            <div class="text" ><?php$sector?></div>
            <div class="image"><img src="./image/marker.png" alt="mail" class="png" /></div>
            <div class="text" ><?php$address?></div>
            <div class="image"><img src="./image/people.png" alt="mail" class="png" /></div>
            <div class="text" ><?php$accepted?></div>
            <div class="image"><img src="./image/star.png" alt="mail" class="png" /></div>
            <div class="text" ><?php$trust?></div>
        </section>
        <section>
            <div>
                <h2>Evaluations :</h2>
            </div>
            <div class ="cadrejaunerech">
                <div class="image"><img src="./image/Profil.png" alt="mail" class="png" /></div>
                <div class="text" ><?php$student?></div>
                <div class="image"><img src="./image/malette.png" alt="mail" class="png" /></div>
                <div class="text" ><?php$job?></div>
                <div class="image"><img src="./image/planning.png" alt="mail" class="png" /></div>
                <div class="text" ><?php$duartion?></div>
                <div class="image"><img src="./image/star.png" alt="mail" class="png" /></div>
                <div class="text" ><?php$evaluation?></div>
            </div>
        </section>
        <section>
            <div>
                <h2>Evaluer l'entreprise ?</h2>
            </div>
            <div class ="cadregris">
                <form action="evaluate.php">
                    <div class="image"><img src="./image/star.png" alt="mail" class="png" /></div>
                    <input type="number" class="nombre" name="evaluation"/>
                    <p class="p">/5<p>
                    <button class="buttonenvoyer" type="submit"><b>Envoyer</b></button>
                </form>
            </div>
        </section>
        <section style="align-items: center;text-align: center;">        
        <form action="delete_entreprise.php" method="get">
                <button class="buttonsub" type="submit"><b>Supprimer</b></button>
            </form>
            <form action="Page modification entreprise.html" method="get">
                <button class="buttonsub" type="submit"><b>Modifier</b></button>
            </form>
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

