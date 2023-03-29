<?php
require_once 'data_base_connexion.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./css/page création compte.css">
    <meta charset="UTF-8" />
    <title>Crée ton comtpe</title>
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
        <div class="cadreconnexion">
        <form action="add_user.php" method="post">
            <h1 class="titre">Crée ton compte</h1>

            <ul class="removep">
                <li>
                    <h4 class="textecadre">Prénom</h4>
                    <input class="inputcadre" type="text" name="prenom"/>
                </li>
                <li>
                    <h4 class="textecadre">Nom</h4>
                    <input class="inputcadre" type="text" name="nom"/>
                </li>
                <li>
                    <h4 class="textecadre">Adresse email</h4>
                    <input class="inputcadre" type="text" name="mail"/>
                </li>
                <li>
                    <h4 class="textecadre">Mot de passe</h4>
                    <input class="inputcadre" type="password" name="password"/>
                </li>
                <li>
                    <h4 class="textecadre">Confirmation mot de passe</h4>
                    <input class="inputcadre" type="password" name="passwordVerif"/>
                </li>
                <li>
                    <h4 class="textecadre">Rôle</h4>
                    <div class="list">
                        <select name="role">
                        <?php
if (isset($_SESSION['user_id'])) {
    $id_utilisateur = $_SESSION['user_id'];
    
    // Récupération de la valeur de "ID_Role" à partir de la base de données
    $sql = "SELECT ID_Role FROM utilisateur WHERE ID_Utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_utilisateur);
    $stmt->execute();
    $id_role= $stmt->get_result();

    // Vérification du résultat de la requête
    if ($id_role->num_rows > 0) 
    {
        // Récupération de la première ligne de résultat
        $ligne = $id_role->fetch_assoc();
        $id_role = $ligne["ID_Role"];

        // Affichage des boutons en fonction de la valeur de "ID_Role"
        if ($id_role == 1) {
            // Affichage des deux boutons si l'utilisateur a le rôle 1
            echo '<option value="Pilote">Pilote</option>';
        }
    }
}
        ?>
                            
                            <option value="Etudiant">Etudiant</option>				
                        </select>
                   </div> 
                </li>
            </ul>
            <button class="buttonsub" type="submit"><b>VALIDER</b></button>
        </form>
    </div>
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