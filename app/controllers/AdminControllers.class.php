<?php
class AdminControllers extends VisitorController
{
    private $pathname;
    private $role;
    private $id;
    protected $navBar;
    protected $votersModel;
    protected $usersModel;
    private $userList;
    private $userTableHeader = ["id_user", "Nom", "Prénom", "date de naissance", "civilité", "adresse", "email", "tel", "role"];

    private $sidebarItems = [
        ['url' => 'manage_voters', 'title' => 'Gérer électeurs'],
        ['url' => 'manage_users', 'title' => 'Gérer utilisateurs']
    ];

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

        $this->usersModel = new UsersModel();
        $this->userList = $this->usersModel->getUsers();
    }

    public function dashboard(): string
    {
        if ($this->role === 'admin') {
            if (strpos($this->pathname, '/admin/dashboard') !== false) {
                if (isset($_GET["id"]) && $_GET["id"] == $this->id) {
                    $this->setNavbar();
                    $this->setSidebar($this->sidebarItems);

                    // créer la carte pour les électeurs
                    $totalVoterCount = str_pad((string) $this->votersModel->getTotalVotersCount(), 2, "0", STR_PAD_LEFT);
                    $cardVoter = new CustomCard("Électeurs", "Total : $totalVoterCount");
                    $cardVoter->setBackgroundColor("#39a275");
                    $cardVoter->setTextColor("#fff");
                    $cardVoter->setIcon("how_to_vote");

                    $operatorTotalCount = str_pad((string) $this->usersModel->getOperatorTotalCount(), 2, '0', STR_PAD_LEFT);
                    $cardOperator = new CustomCard("Opérateurs", "Total: $operatorTotalCount");
                    $cardOperator->setBackgroundColor("#8e24aa");
                    $cardOperator->setTextColor("#fff");
                    $cardOperator->setIcon("badge");

                    $cardAdmin = new CustomCard("Admin", "Total: 00");
                    $cardAdmin->setBackgroundColor("#795548");
                    $cardAdmin->setTextColor("#fff");
                    $cardAdmin->setIcon("supervisor_account");

                    $this->templateRenderer->setBodyContent($this->dashboardPageContent([$cardVoter, $cardOperator, $cardAdmin]));
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

    public function routeManageVoters(): string
    {
        $this->setNavbar();
        $this->setSidebar($this->sidebarItems);

        $this->templateRenderer->setBodyContent("test");
        return $this->voterLists([], "");
    }

    public function voterLists(array $columns = array(), $condition = ""): string
    {
        if ($this->role === "admin") {
            if (strpos($this->pathname, '/admin/manage_voters') !== false) {
                $this->tableVoters->setBtnEditVisible(true);
                $this->tableVoters->setAddBtnVisible(true);
                $this->tableVoters->setBtnDeleteVisible(true);
                return parent::voterLists($columns, $condition);
            }
        }
        return parent::voterLists($columns, $condition);
    }

    public function routeManageUsers()
    {
        $this->setNavbar();
        $this->setSidebar($this->sidebarItems);
        $tableUsers = new CustomTable("User", $this->userTableHeader);
        $tableUsers->setBtnEditeState(true);
        $tableUsers->setAddBtnVisible(true);
        $tableUsers->setSearchBarVisible(true);
        $this->templateRenderer->setBodyContent($this->renderUsersTable($tableUsers->renderTable()));
        return $this->templateRenderer->render("Manage Users");
    }

    private function renderUsersTable($component): string
    {
        return <<<HTML
            <div class="d-flex w-100 justify-content-center">
                $component
            </div>
        HTML;
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

    private function renderSideBarItems(array $items): string
    {
        $sidebarItems = "";
        $count = count($items);

        // Ajoute le lien du tableau de bord avec l'ID par défaut
        $sidebarItems .= "<a class=\"text-decoration-none text-white\" style=\"font-size: 1.3rem\" href=\"dashboard?id={$this->id}\">Tableau de bord</a>";

        // Ajoute les autres éléments de la barre latérale
        foreach ($items as $index => $item) {
            $url = $item['url'];
            $title = $item['title'];

            $sidebarItems .= "<hr class=\"p-0 m-0 text-white\">"; // Ajoute toujours une ligne de séparation avant les autres éléments
            $sidebarItems .= "<a class=\"text-decoration-none text-white\" style=\"font-size: 1.3rem\" href=\"$url\">$title</a>";
        }

        return <<<HTML
    <div class="d-flex flex-column bg-dark p-2">
        $sidebarItems
    </div>
    HTML;
    }

    private function setNavbar()
    {
        $this->navBar = $this->getNavbar();
        $this->navBar->setMenuVisible(true);
        $this->templateRenderer->setNavbarContent($this->navBar->render());
    }

    private function setSidebar(array $sidebarItems)
    {
        $sidebarContent = $this->renderSideBarItems($sidebarItems);
        $this->templateRenderer->setSidebarContent($sidebarContent);
    }
}
