<?php
class AdminControllers extends VisitorController
{
    private $pathname;
    private $role;
    private $id;
    protected $navBar;

    function __construct(TemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);
        $this->pathname = $_SERVER["REQUEST_URI"];

        if (isset($_SESSION["user"]["role"])) {
            $this->role = $_SESSION["user"]["role"];
        }

        if (isset($_SESSION["user"]["id_user"])) {
            $this->id = $_SESSION["user"]["id_user"];
        }
    }

    function dashboard(): string
    {
        if ($this->role === 'admin') {
            if (strpos($this->pathname, '/admin/dashboard') !== false) {
                if (isset($_GET["id"]) && $_GET["id"] == $this->id) {
                    $this->templateRenderer->setNavbarContent($this->getNavbar());
                    $this->templateRenderer->setBodyContent("test");
                    return $this->templateRenderer->render("Dashboard");
                } else {
                    // L'ID dans l'URL est invalide
                    $this->templateRenderer->setError("Error", "Accès non autorisé : l'utilisateur n'est pas un utilisateur régulier.");
                    return $this->templateRenderer->render("Error");
                }
            }
        }
        return "Error: Unable to get voters";
    }
}
