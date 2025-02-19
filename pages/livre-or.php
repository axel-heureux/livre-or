<?php
session_start();
require 'config.php'; // Connexion à la base de données

$comments = $pdo->query("SELECT user.login, comment.comment, comment.date FROM comment JOIN user ON comment.id_user = user.id ORDER BY comment.date DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Stylesheet/index.css">
    <title>Livre d'or</title>
</head>
<body>
    <header>
        <nav>
            <a href="accueil.php">Accueil</a>
            <a href="profil.php">Profil</a>
            <a href="commentaires.php">Commentaires</a>
            <a class="active" href="livre-or.php">Livre-or</a>
        </nav>
    </header>
    <main>
        <section class="comments-section">
            <h1>Commentaires du Livre d'Or</h1>
            
            <!-- Tableau des commentaires -->
            <table class="comments-table">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Date</th>
                        <th>Commentaire</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($comments as $comment) : ?>
                        <tr>
                            <td><?= htmlspecialchars($comment['login']) ?></td>
                            <td><?= $comment['date'] ?></td>
                            <td><?= nl2br(htmlspecialchars($comment['comment'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
