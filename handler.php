<?php
require_once 'data_base_connexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if (isset($_POST['butrecherche'])) {
        $but = $_POST['butrecherche'];
    
        if ($action == 'rechercher') {
            if($but == "roffre"){
                $competence = isset($_POST['competence']) ? $_POST['competence'] : '';
                $entreprise = isset($_POST['entreprise']) ? $_POST['entreprise'] : '';
                $duree = isset($_POST['duree']) ? $_POST['duree'] : '';
                $ville = isset($_POST['ville']) ? $_POST['ville'] : '';
                $publication = isset($_POST['publication']) ? $_POST['publication'] : '';
                header("Location: recherche_offre.php?competence=" . urlencode($competence)."&entreprise=".urlencode($entreprise)."&duree=".urlencode($duree)."&ville=".urlencode($ville)."&publication=".urlencode($publication));
                exit();
            } elseif($but == "rentreprise"){
                $entreprise = isset($_POST['entreprise']) ? $_POST['entreprise'] : '';
                header("Location: Page présentation entreprise.php?entreprise=" . urlencode($entreprise));
                exit();
            } elseif($but == "retudiant" || $but == "rpilote"){
                $nom_recherché = isset($_POST['nom_recherché']) ? $_POST['nom_recherché'] : '';
                $prenom_recherché = isset($_POST['prenom_recherché']) ? $_POST['prenom_recherché'] : '';

                $sql3 = "SELECT Role FROM utilisateur 
                         JOIN Role ON utilisateur.ID_Role=Role.ID_Role 
                         WHERE SOUNDEX(Prenom) = SOUNDEX(?) 
                         AND SOUNDEX(Nom) = SOUNDEX(?);";
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param('ss', $prenom_recherché, $nom_recherché);
                $stmt3->execute();
                $result = $stmt3->get_result();
                $row = $result->fetch_assoc();
                $role = $row['Role'];
                $stmt3->close();

                if (($role == 'Etudiant' && $but == "retudiant") || ($role == 'Pilote' && $but == "rpilote")) {
                    header("Location: Page présentation profil.html?nom_recherché=" . urlencode($nom_recherché)."&prenom_recherché=".urlencode($prenom_recherché)."&role=".urlencode($role));
                    exit();
                } elseif ($role == 'Etudiant' && $but == "rpilote") {
                    header("Location: accueil.html");
                    exit();
                } elseif ($role == 'Pilote' && $but == "retudiant") {
                    header("Location: accueil.html");
                    exit();
                } else {
                    header("Location: accueil.html");
                    exit();
                }
            }
        }

        if ($action == 'entreprise') {
            header("Location: Page création entrprise.html");
            exit();
        } elseif ($action == 'compte') {
            header("Location: Page création compte.html");
            exit();
        } elseif ($action == 'offre') {
            header("Location: Page création offre.html");
            exit();
        }
    }
}
?>
