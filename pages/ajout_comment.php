<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['login'])) {
    // Rediriger si l'utilisateur n'est pas connecté
    header("Location: login.php"); // Rediriger vers la page de connexion ou autre page appropriée
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et nettoyer les données du formulaire
    $auteur = trim($_POST['auteur']);
    $message = trim($_POST['message']);

    // Vérifier que l'auteur et le message ne sont pas vides
    if (!empty($auteur) && !empty($message)) {
        // Récupérer l'ID de l'utilisateur connecté
        $user_id = $_SESSION['login']; // ID utilisateur récupéré de la session

        // Préparer et exécuter la requête pour insérer le commentaire
        $stmt = $pdo->prepare("INSERT INTO comment (comment, id_user, date) VALUES (?, ?, NOW())");
        $stmt->execute([$message, $user_id]); // Utiliser l'ID de l'utilisateur
    }
}

// Rediriger vers la page des commentaires après l'ajout
header("Location: commentaires.php");
exit();
?>
