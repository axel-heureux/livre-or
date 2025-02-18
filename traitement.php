<?php

class Database {
    private $host = "localhost";
    private $dbname = "livreor";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
}

class User {
    private $db;

    public function __construct($database) {
        $this->db = $database->conn;
    }

    public function register($login, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hachage sécurisé du mot de passe

            $sql = "INSERT INTO user (login, password) VALUES (:login, :password)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                "login" => $login,
                "password" => $hashedPassword
            ]);

            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de l'inscription : " . $e->getMessage());
        }
    }
}

// Initialisation de la base de données
$database = new Database();
$user = new User($database);

// Vérification si le formulaire est soumis
if (isset($_POST['ok'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    if (!empty($login) && !empty($password)) {
        $user->register($login, $password);
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

?>
