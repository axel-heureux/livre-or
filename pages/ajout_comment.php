<?php
session_start();
require 'config.php'; // Connexion à la base de données

class CommentHandler {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isUserLoggedIn() {
        return isset($_SESSION['user']['login']);
    }

    public function getUserId($login) {
        $stmt = $this->pdo->prepare("SELECT id FROM user WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user['id'] : null;
    }

    public function addComment($userId, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO comment (comment, id_user, date) VALUES (?, ?, NOW())");
        $stmt->execute([$message, $userId]);
    }
}

$commentHandler = new CommentHandler($pdo);

if (!$commentHandler->isUserLoggedIn()) {
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $auteur = trim($_POST['auteur']);
    $message = trim($_POST['message']);

    if (!empty($auteur) && !empty($message)) {
        $userId = $commentHandler->getUserId($_SESSION['user']['login']);
        if ($userId) {
            $commentHandler->addComment($userId, $message);
        } else {
            die("Erreur : utilisateur non trouvé.");
        }
    }
}

// Redirection après ajout
theader("Location: commentaires.php");
exit();
?>
