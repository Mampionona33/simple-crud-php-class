<?php
class AdminControllers extends VisitorController
{
    private $pathname;
    private $role;
    private $id;
    protected $navBar;
    protected $votersModel;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);

        $this->votersModel = parent::getVoterModel();
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

                    // créer la carte pour les électeurs
                    $totalVoterCount = str_pad((string) $this->votersModel->getTotalVotersCount(), 2, "0", STR_PAD_LEFT);
                    $cardVoter = new CustomCard("Électeurs", "Total : $totalVoterCount");
                    $cardVoter->setBackgroundColor("#39a275");
                    $cardVoter->setTextColor("#fff");
                    $cardVoter->setIcon("how_to_vote");

                    $cardOperator = new CustomCard("Operator", "Total:3");
                    $cardOperator->setBackgroundColor("#8e24aa");
                    $cardOperator->setTextColor("#fff");
                    $cardOperator->setIcon("badge");

                    $this->templateRenderer->setSidebarContent("test");
                    $this->templateRenderer->setBodyContent($this->dashboardPageContent([$cardVoter, $cardOperator]));
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
        <div class="d-flex p-5 align-self-sm-start justify-content-start" style="margin-top: 3rem;">
            $content
        </div>
        HTML;
    }
}
