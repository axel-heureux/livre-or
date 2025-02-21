<?php
session_start();

class UserLogout {
    public static function logout(): void {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location: login.php");
        exit();
    }
}

UserLogout::logout();
?>