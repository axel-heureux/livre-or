<?php
require 'config.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet/index.css"> <!-- Le bon fichier CSS pour la page d'accueil -->
    <title>Accueil</title>
</head>
<body>
    <header>
        <nav>
            <a class="active" href="accueil.php">Accueil</a> <!-- Lien actif sur la page Accueil -->
            <a href="profil.php">Profil</a>
            <a href="commentaires.php">Commentaires</a>
            <a href="livre-or.php">Livre-or</a>
            <a href="logout.php" class="logout-btn">Déconnexion</a> <!-- Bouton de déconnexion -->
        </nav>
    </header>

    <section class="home">
        <div class="home-content">
            <h1>✨ Bienvenue, <?php echo htmlspecialchars($_SESSION['user']['login']); ?> ! ✨</h1>
            <p>📖 Partagez votre avis et découvrez ceux des autres ! Connectez-vous pour :</p>
            <ul>
                <li>✅ Écrire un commentaire  📝 </li>
                <li>✅ Consulter et rechercher des avis 🔍</li>
                <li>✅ Modifier votre profil 🔑</li>
                <li>💬 Exprimez-vous et faites partie de notre communauté ! 🚀</li>
            </ul>
            <a href="commentaires.php" class="cta">Ajouter un Commentaire</a>
        </div>
    </section>
</body>
</html>
