<?php
$host = 'localhost';  // Votre serveur de base de données (souvent 'localhost')
$dbname = 'livreor';   // Le nom de votre base de données
$username = 'root';    // Votre nom d'utilisateur de base de données (souvent 'root' pour local)
$password = '';        // Votre mot de passe de base de données (par défaut vide pour localhost)

try {
    // Création de l'objet PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer le mode d'erreur
} catch (PDOException $e) {
    // Afficher un message d'erreur en cas de problème
    die("Erreur de connexion : " . $e->getMessage());
}
