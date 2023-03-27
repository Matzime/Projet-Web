<?php
require_once 'data_base_connexion.php';
session_start();

function get_client_ip() {
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else
        $ip = $_SERVER['REMOTE_ADDR'];

    return $ip;
}

function generateToken($length = 64)
{
    return bin2hex(random_bytes($length / 2));
}

function storeRememberToken($user_id, $token, $conn)
{
    $expires_at = date('Y-m-d H:i:s', time() + (86400 * 30));
    $sql = "INSERT INTO remember_tokens (token, user_id, expires_at) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $token, $user_id, $expires_at);
    $stmt->execute();
}

function checkRememberToken($token, $conn)
{
    $sql = "SELECT * FROM remember_tokens WHERE token = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token_data = $result->fetch_assoc();
        if (strtotime($token_data['expires_at']) > time()) {
            return $token_data['user_id'];
        }
    }
    return false;
}

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    echo "Connexion réussie. Bienvenue, " . $_SESSION['user_email'] . "!";
    exit;
}

// Configuration de la protection contre la force brute
$MAX_ATTEMPTS = 5;
$TIME_LIMIT = 15 * 60; // 15 minutes

//Verification du nombre de tentatives de connexion
$ip_address = get_client_ip();
$current_time = date('Y-m-d H:i:s');

// Vérifiez le nombre de tentatives de connexion échouées pour cette adresse IP
$sql = "SELECT COUNT(*) as count FROM failed_login_attempts WHERE ip_address = ? AND attempt_time > DATE_SUB(?, INTERVAL ? SECOND)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $ip_address, $current_time, $TIME_LIMIT);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$failed_attempts = $row['count'];

if ($failed_attempts >= $MAX_ATTEMPTS) {
    echo "Trop de tentatives de connexion. Veuillez réessayer plus tard.";
} else {
// Vérifier si les cookies d'authentification existent et restaurer la session si nécessaire
if (isset($_COOKIE['remember_token'])) {
    $user_id = checkRememberToken($_COOKIE['remember_token'], $conn);
    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
    }

} else {
$Mail = $_POST['login'];
$MDP = $_POST['password'];

// Préparer la requête SQL
$sql = "SELECT * FROM utilisateur WHERE Mail = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $Mail);

// Exécuter la requête
$stmt->execute();

$result = $stmt->get_result();

// Vérifier si l'utilisateur existe
if ($result->num_rows > 0) {
    // Récupérer les données de l'utilisateur
    $user = $result->fetch_assoc();

    // Vérifier le mot de passe
    if (password_verify($MDP, $user['MDP'])) {
        // Les identifiants sont corrects
        echo "Connexion réussie. Bienvenue, " . $user['Mail'] . "!";

        // Stocker les informations d'authentification dans la session
        $_SESSION['user_email'] = $user['Mail'];
        $_SESSION['user_id'] = $user['ID_Utilisateur'];

        // Vérifiez si la case "Se souvenir de moi" a été cochée
        if (isset($_POST['remember_me'])) {
            // Créez des cookies pour stocker les informations d'authentification
            setcookie('user_email', $user['Mail'], time() + (86400 * 30), "/"); // Stocke l'e-mail pendant 30 jours
            setcookie("user_id", $user['ID_Utilisateur'], time() + (86400 * 30), "/"); // Le cookie expirera après 30 jours
        }
    } else {
        // Le mot de passe est incorrect
        echo "Erreur : mot de passe incorrect.";
        //Ajout à la table failed_login_attempts d'une connexion échoué
        $sql = "INSERT INTO failed_login_attempts (ip_address, attempt_time) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $ip_address, $current_time);
        $stmt->execute();
    }
}}}
?>
