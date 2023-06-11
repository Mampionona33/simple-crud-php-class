<?php
class AuthController
{
    public function __construct()
    {
    }

    public static function sessionController()
    {
        session_start();
        $pathname = $_SERVER["REQUEST_URI"];
        // Supprimer les éventuels paramètres de requête de la fin du pathname
        $pathname = strtok($pathname, '?');

        // Vérifier si l'utilisateur est authentifié
        if (!isset($_SESSION["user"])) {
            // Rediriger vers la page de connexion
            if ($pathname !== '/login' && $pathname !== '/') {
                header("Location: /login");
                exit();
            }
        } else {
            $role = $_SESSION["user"]["role"];
            $id = $_SESSION["user"]["id"];
            if ($role === "operator") {
                if ($pathname === '/') {
                    header("Location: /operator/dashboard?id=$id");
                    exit();
                }
            } elseif ($role === "admin") {
                if ($pathname === '/') {
                    header("Location: /admin/dashboard?id=$id");
                    exit();
                }
            }
        }
    }

    public static function login(): string
    {
        $usersModel = new UsersModel();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["email"])) {
                $authUser = $usersModel->getUserByEmail($_POST["email"]);
                var_dump($authUser);
            }
        }
        return LoginViews::render();
    }
}
