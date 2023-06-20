<?php
class AdminControllers extends VisitorController
{
    private $pathname;
    private $role;
    private $id;
    protected $navBar;

    public function __construct(TemplateRenderer $templateRenderer)
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

    public function dashboard(): string
    {
        if ($this->role === 'admin') {
            if (strpos($this->pathname, '/admin/dashboard') !== false) {
                if (isset($_GET["id"]) && $_GET["id"] == $this->id) {
                    $this->navBar = $this->getNavbar();
                    $this->navBar->setMenuVisible(true);
                    $this->templateRenderer->setNavbarContent($this->navBar->render());

                    $cardVoter = new CustomCard("Electeur", "Total:1000");
                    $cardVoter->setIcon("face");

                    $cardUser = new CustomCard("User", "Total:3");
                    $cardUser->setIcon("person");

                    $this->templateRenderer->setSidebarContent("test");
                    $this->templateRenderer->setBodyContent($this->dashboardPageContent([$cardVoter, $cardUser]));
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

    private function dashboardPageContent(array $elements): string
    {
        $content = "";
        foreach ($elements as $value) {
            $content .= $value->__invoke();
        }
        return <<<HTML
        <div class="d-flex justify-content-between">
            $content
        </div>
        HTML;
    }
}