<?php
session_start();
require 'config.php'; // Connexion à la base de données

if (!isset($_SESSION['login'])) { // Vérifie si l'utilisateur est connecté avec son ID
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_login = trim($_POST['login'] ?? '');
    $new_password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm-password'] ?? '');
    $user_id = $_SESSION['user_id']; // Récupération de l'ID utilisateur

    if (empty($new_login) || empty($new_password) || empty($confirm_password)) {
        echo "Tous les champs doivent être remplis.";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Hash du mot de passe pour sécuriser la mise à jour
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    try {
        $stmt = $bdd->prepare("UPDATE user SET login = ?, password = ? WHERE id = ?");
        $stmt->execute([$new_login, $hashed_password, $user_id]);

        // Met à jour la session avec le nouveau login
        $_SESSION['login'] = $new_login;
        
        echo "Mise à jour réussie.";
        header("Location: profil.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
} else {
    echo "Méthode non autorisée.";
}
?>
