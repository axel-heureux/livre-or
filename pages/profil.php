<?php
session_start();
require 'config.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet/index.css"> <!-- Le bon fichier CSS pour la page -->
    <title>Profil</title>
</head>
<body>

    <header>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="profil.php">Profil</a>
            <a href="commentaires.php">Commentaires</a>
            <a href="livre-or.php">Livre-or</a>
            <a href="logout.php" class="logout-btn">Déconnexion</a> <!-- Bouton de déconnexion -->
        </nav>
    </header>

    <section class="form-section">
        <h1>Modifier votre Login et Mot de Passe</h1>
        <form action="edit_login.php" method="POST">
            <div class="form-group">
                <label for="login">Nouveau Login :</label>
                <input type="text" id="login" name="login" required>
            </div>

            <div class="form-group">
                <label for="password">Nouveau Mot de Passe :</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm-password">Confirmer le Mot de Passe :</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>

            <button type="submit">Mettre à jour</button>
        </form>
    </section>

</body>
</html>