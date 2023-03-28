<?php
$nameJob = "Nom Offre"; // Remplacez "Nom Offre" par la valeur que vous souhaitez stocker dans le cookie
setcookie("nameJob", $nameJob, time() + 3600, "/"); // Créer un cookie nommé "nom_offre" avec une durée de vie de 1 heure
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page présentation offre.css">
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
                <h1>Nom Offre</h1>
            </div>
        </section>
        <div>
            <h2>Informations :</h2>
        </div>
        <section class ="cadregris">
            <div class="image"><img src="./image/building.png" alt="mail" class="png" /></div>
            <div class="text" >Entreprise</div>
            <div class="image"><img src="./image/money.png" alt="mail" class="png" /></div>
            <div class="text" >Argent</div>
            <div class="image"><img src="./image/marker.png" alt="mail" class="png" /></div>
            <div class="text" >Adresse</div>
            <div class="image"><img src="./image/planning.png" alt="mail" class="png" /></div>
            <div class="text" >Durée</div>
            <div class="image"><img src="./image/past.png" alt="mail" class="png" /></div>
            <div class="text" >Date publication</div>
            <div class="image"><img src="./image/people.png" alt="mail" class="png" /></div>
            <div class="text" >Nmb poste proposé</div>
            <p></p>
            <div><h3>Compétences requises :</h3></div>
            <div class="skills">
                <div class="skill">
                    <b>Skill1</b>
                </div>
            </div>
        </section>
        <form action="wishlist.php">
                <div class="wishlist"><h4>Mettre cette offre dans votre wish-list :</h4> 
                <button class="buttonsub3" type="submit"><img src="./image/heart.png" alt="mail" class="png" /></button>
            </div>
        </form>  
        <div>
            <h2>Envie de postuler ?</h2>
        </div>
        <section class ="cadregris">
        <form action="apply_job.php">
                <h3>CV :</h3>
                <input type="file" id="CV" name="cv" accept="application/pdf,application/vnd.ms-excel">
                <p></p>
                <h3>Lettre de motivation :</h3>
                <input  type="file" id="letter" name="letter" accept="application/pdf,application/vnd.ms-excel">
                <button class="buttonsub" type="submit"><b>Envoyer</b></button>
            </form>
        </section>
        <section style="align-items: center;text-align: center;">      
        <form action="delete_job.php">
            <button class="buttonsub" type="submit"><b>Supprimer</b></button>
        </form> 
        <form action="update_job.php">
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