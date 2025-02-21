<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Connexion</title>
</head>
<body>
<?php
session_start();

class Database {
    private PDO $conn;
    public function __construct(string $host, string $dbname, string $username, string $password) {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }
    public function getConnection(): PDO {
        return $this->conn;
    }
}

class UserAuthentication {
    private PDO $conn;
    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }
    public function loginUser(string $login, string $password): ?array {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($user && password_verify($password, $user['password'])) ? $user : null;
    }
}

$database = new Database('localhost', 'livreor', 'root', '');
$conn = $database->getConnection();
$auth = new UserAuthentication($conn);
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    if (!empty($login) && !empty($password)) {
        $user = $auth->loginUser($login, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            header("Location: accueil.php");
            exit;
        } else {
            $error_msg = "Nom d'utilisateur ou mot de passe incorrect !";
        }
    } else {
        $error_msg = "Veuillez remplir tous les champs !";
    }
}
?>

<header class="header">
    <a href="index.php" class="logo"><span>Livre</span>D'or</a>
    <a href="login.php" class="contact">Login</a>
</header>

<form method="POST" action="">
    <h3 class="titre_connexion">Connexion</h3>
    <label for="login"><b>Login</b></label>
    <input type="text" id="login" name="login" placeholder="Entrez votre nom d'utilisateur" required>
    <br>
    <label for="password"><b>Password</b></label>
    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
    <br>
    <input type="submit" value="Se connecter" name="ok">
    <a href="inscription.php">Vous n’êtes pas encore inscrit ?</a>
    <?php if (!empty($error_msg)) : ?>
        <p style="color: red;"> <?php echo htmlspecialchars($error_msg); ?> </p>
    <?php endif; ?>
</form>
</body>
</html>
