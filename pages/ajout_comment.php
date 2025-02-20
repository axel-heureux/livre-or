<?php
session_start();
require 'config.php'; // Connexion à la base de données

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user']['login'])) {
    //header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auteur = trim($_POST['auteur']);
    $message = trim($_POST['message']);

    if (!empty($auteur) && !empty($message)) {
        // Récupérer l'ID de l'utilisateur connecté à partir de la table "user"
        $stmt = $pdo->prepare("SELECT id FROM user WHERE login = ?");
        $stmt->execute([$_SESSION['user']['login']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_id = $user['id']; // ID de l'utilisateur

            // Insérer le commentaire avec l'ID utilisateur
            $stmt = $pdo->prepare("INSERT INTO comment (comment, id_user, date) VALUES (?, ?, NOW())");
            $stmt->execute([$message, $user_id]);
        } else {
            die("Erreur : utilisateur non trouvé.");
        }
    }
}

// Redirection après ajout
header("Location: commentaires.php");
exit();
?>
