<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stagexplorer";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
  die("Connection Error: " . $conn->connect_error);
}
//echo "Connected Succefully";
?>
