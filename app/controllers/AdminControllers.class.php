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
                    $this->navBar = $this->getNavbar();
                    $this->navBar->setMenuVisible(true);
                    $this->templateRenderer->setNavbarContent($this->navBar->render());


                    $cardVoter = new CustomCard("Electeur", "Total:1000");
                    $this->templateRenderer->setSidebarContent("test");
                    $this->templateRenderer->setBodyContent($cardVoter());
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

    // private function customCard(): string
    // {
    //     return '
    //     <div class="global-data-card">
    //         <div class="card border-0">
    //             <div class="card-body" style="background-color: red;">
    //                 <div class="d-flex gap-5 align-items-center">
    //                     <h5 class="card-title">Voter</h5>
    //                     <span class="material-icons-outlined rounded-circle p-2" style="background-color:#fff"}>
    //                         people_alt
    //                     </span>
    //                 </div>
    //                 <h6 class="card-subtitle mb-2 text-muted">Total: 1000</h6>
    //             </div>
    //         </div>
    //     </div>
    //     ';
    // }
}
