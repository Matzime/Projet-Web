<?php
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
       exit();}

       elseif($but == "rentreprise"){
        $entreprise = isset($_POST['entreprise']) ? $_POST['entreprise'] : '';

        // Redirigez vers "rechercher_offre.php" avec la variable "entreprise" en paramètre
        header("Location: Page présentation entreprise.php?entreprise=" . urlencode($entreprise));
        exit();}

        elseif($but == "retudiant"){
            $ID_utilisateur = $_COOKIE(user_id);

            // Redirigez vers "rechercher_offre.php" avec la variable "entreprise" en paramètre
            header("Location: Page présentation profil.php?ID_utilisateur=" . urlencode($ID_utilisateur));
            exit();}
        }

    } elseif ($action == 'entreprise') {
        
    } elseif ($action == 'compte') {
        header("Location: Page création compte.php");
        exit();
    } elseif ($action == 'offre') {

       header("Location: Page création offre.php");
       exit();
    }
}}
?>