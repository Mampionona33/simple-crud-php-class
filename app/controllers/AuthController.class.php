<?php
class AuthController
{
    private $templateRenderer;
    public function __construct()
    {
    }

    public function setTemplateRenderer(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function sessionController()
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
            $id = $_SESSION["user"]["id_user"];
            
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

    public function login(): string
    {
        $usersModel = new UsersModel();
        $loginViews = new LoginViews();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST["email"]) && isset($_POST["password"])) {
                $authUser = $usersModel->getUserByEmail($_POST);
                if (count($authUser) > 0) {
                    $userRole = $authUser[0]["role"];
                    if (preg_match('/admin/i', $userRole)) {
                        $_SESSION['user'] = $authUser[0];
                        header("Location: /admin/dashboard?id=" . $authUser[0]['id_user']);
                        exit();
                    } else {
                        $this->templateRenderer->setError("Error", "User is not an admin");
                    }
                } else {
                    $this->templateRenderer->setError("Error", "Identifiant ou mots de passe incorrecte");
                    header("Refresh: 3 /login");
                }
            }
        }
        $loginViews->setTemplateRenderer($this->templateRenderer);
        return $loginViews->render();
    }

    public function logout()
    {
        session_destroy();
        header("Location: /login");
        exit();
    }
}
