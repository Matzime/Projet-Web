<?php
require_once 'data_base_connexion.php';
$fstname = isset($_GET['prenom_recherché']) ? $_GET['prenom_recherché'] : 'Prénom';
$sndname = isset($_GET['nom_recherché']) ? $_GET['nom_recherché'] : 'Nom';
$role = isset($_GET['role']) ? $_GET['role'] : 'Role';

$sql = "SELECT * FROM utilisateur 
JOIN centre ON centre.ID_Centre = utilisateur.ID_Centre
JOIN appartenir ON appartenir.ID_Utilisateur = utilisateur.ID_Utilisateur
JOIN promo ON appartenir.ID_Promo = promo.ID_Promo Where SOUNDEX(Prenom) = SOUNDEX('$fstname') AND SOUNDEX(Nom) = SOUNDEX('$sndname');";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $promo = $row['Promo'];
    $mail = $row['Mail'];
    $campus = $row['Centre'];
} /* else {
    header("Location: accueil.html");
    exit();
} */


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page présentation profil.css">
    <meta charset="UTF-8" />
    <title><?php echo $fstname.' '.$sndname?></title>
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
            <div class="nomprenom">
                <h1><?php echo $fstname.' '.$sndname?></h1>
            </div>
            <div class="profil">
                <img src="./image/Profil.png" alt="profil"/>
            </div>
        </section>
        <div>
            <h2>Informations :</h2>
        </div>
        <section class ="cadrejaunerech">
            <div class="image"><img src="./image/mail.png" alt="mail" class="png" /></div>
            <div class="text" ><?php echo $mail?></div>
            <div class="image"><img src="./image/badge.png" alt="mail" class="png" /></div>
            <div class="text" ><?php echo $role?>:<?php echo $promo?></div>
            <div class="image"><img src="./image/building.png" alt="mail" class="png" /></div>
            <div class="text" ><?php echo $campus?></div>
        </section>
        <!-- <section>
            <div>
                <h2>Wish-list :</h2>
            </div>
            <div class ="cadregris">
                <form action="delete_wishlist.php">
                    <h3><?php echo $nameJob?></h3>
                    <div class="image"><img src="./image/entreprise.png" alt="mail" class="png" /></div>
                    <div class="text2" ><?php echo $enterprise?></div>
                    <div class="image"><img src="./image/money.png" alt="mail" class="png" /></div>
                    <div class="text2" ><?php echo $money?></div>
                    <button class="buttonsub2" type="submit"><img src="./image/heart.png" alt="mail" class="png" /></button>
                    <p></p>
                    <div class="image"><img src="./image/marker.png" alt="mail" class="png" /></div>
                    <div class="text2" ><?php echo $address?></div>
                    <div class="image"><img src="./image/planning.png" alt="mail" class="png" /></div>
                    <div class="text2" ><?php echo $duration?></div>
                </form>
            </div>
        </section> -->
        <?php
if (isset($_SESSION['user_id'])) {
    $id_utilisateur = $_SESSION['user_id'];
    
    // Récupération de la valeur de "ID_Role" de l'utilisateur à partir de la base de données
    $sql = "SELECT ID_Role FROM utilisateur WHERE ID_Utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_utilisateur);
    $stmt->execute();
    $id_role= $stmt->get_result();

    // Récupération de la valeur de "ID_Utilisateur" du la page profil à partir de la base de données
    $sql1 = "SELECT ID_utilisateur FROM utilisateur WHERE prenom LIKE CONCAT('%', ?, '%') AND nom LIKE CONCAT('%', ?, '%')";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param('ss', $fstName, $sndName);
    $stmt1->execute();
    $id_profil= $stmt1->get_result();

    // Récupération de la valeur de "ID_Role" du la page profil à partir de la base de données
    $sql2 = "SELECT ID_Role FROM utilisateur WHERE ID_Utilisateur = ?";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('i', $id_profil);
    $stmt2->execute();
    $id_role_profil= $stmt->get_result();

    // Vérification du résultat de la requête
    if ($id_role->num_rows > 0) 
    {
        // Récupération de la première ligne de résultat
        $ligne = $id_role->fetch_assoc();
        $id_role = $ligne["ID_Role"];

        // Affichage des boutons en fonction de la valeur de "ID_Role"
        if ($id_role == 1) 
        {
            // Affichage des deux boutons si l'utilisateur a le rôle 1

            echo '<section style="align-items: center;text-align: center;">
            <form action="delete_profil.php"><button class="buttonsub" type="submit"><b>Supprimer</b></button></form>
            <form action="Page modification profil.html"><button class="buttonsub" type="submit"><b>Modifier</b></button>
            </form></section>';
        }
        if ($id_role == 2) 
        {
            if ($id_role_profil == 3)
            // Affichage des deux boutons si l'utilisateur a le rôle 1

            echo '<section style="align-items: center;text-align: center;">
            <form action="delete_profil.php"><button class="buttonsub" type="submit"><b>Supprimer</b></button></form>
            <form action="Page modification profil.html"><button class="buttonsub" type="submit"><b>Modifier</b></button>
            </form></section>';
        }
    }
}
        ?>
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