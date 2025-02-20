<?php
session_start();

class Database {
    private PDO $conn;

    public function __construct(string $host, string $dbname, string $username, string $password) {
        $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO {
        return $this->conn;
    }
}

class UserProfile {
    private PDO $conn;
    private int $userId;

    public function __construct(PDO $conn, int $userId) {
        $this->conn = $conn;
        $this->userId = $userId;
    }

    public function updateProfile(string $newLogin, string $newPassword): bool {
        // Optionnel : vérifier la validité du mot de passe
        if (strlen($newPassword) < 6) {
            throw new InvalidArgumentException("Le mot de passe doit comporter au moins 6 caractères.");
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            $sql = "UPDATE user SET login = :login, password = :password WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':login', $newLogin, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new RuntimeException("Erreur lors de la mise à jour : " . $e->getMessage());
        }
    }
}

// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'livreor';
$username = 'root';
$password = '';
$db = new Database($host, $dbname, $username, $password);
$conn = $db->getConnection();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    echo "Vous devez être connecté pour modifier votre profil.";
    exit;
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer les nouvelles valeurs du formulaire
        $newLogin = htmlspecialchars($_POST['login']);
        $newPassword = htmlspecialchars($_POST['password']);

        $userProfile = new UserProfile($conn, $_SESSION['user']['id']);
        if ($userProfile->updateProfile($newLogin, $newPassword)) {
            // Rediriger l'utilisateur après la mise à jour
            header("Location: login.php");
            exit();
        }

    } catch (InvalidArgumentException $e) {
        echo $e->getMessage();
        exit;
    } catch (RuntimeException $e) {
        echo $e->getMessage();
        exit;
    }
}
?>
