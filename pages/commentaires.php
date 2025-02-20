<?php
session_start();
require 'config.php'; // Connexion à la base de données


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auteur = trim($_POST['auteur']);
    $message = trim($_POST['message']);

    // Vérifier que l'auteur et le message ne sont pas vides
    if (!empty($auteur) && !empty($message)) {
        // Préparer et exécuter la requête pour insérer le commentaire
        $stmt = $pdo->prepare("INSERT INTO comment (comment, id_user, date) VALUES (?, ?, NOW())");
        $stmt->execute([$message, $_SESSION['user_id'] ?? 0]); // Utiliser 0 si l'utilisateur n'est pas connecté
    }
}

// Récupérer les commentaires et les afficher
$comments = $pdo->query("SELECT user.login, comment.comment, comment.date FROM comment JOIN user ON comment.id_user = user.id ORDER BY comment.date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet/commentaires.css">
    <title>Commentaires</title>
</head>
<body>
    <header>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="profil.php">Profil</a>
            <a class="active" href="commentaires.php">Commentaires</a>
            <a href="livre-or.php">Livre-or</a>
            <a href="logout.php" class="logout-btn">Déconnexion</a> <!-- Bouton de déconnexion -->
        </nav>
    </header>
    <main>
        <section class="comment-section">
            <h1>Vos Commentaires</h1>
            <form action="ajout_comment.php" method="POST" class="comment-form">
                <label for="auteur">Votre Nom :</label>
                <input type="text" id="auteur" name="auteur" required>
                <label for="message">Votre Commentaire :</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
            <div class="comments">
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment">
                        <p><strong><?= htmlspecialchars($comment['login']) ?></strong> - <?= $comment['date'] ?></p>
                        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>
