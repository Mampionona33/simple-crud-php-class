<?php
class AdminController
{
    private $uri;
    private $usersModel;
    private $templateRenderer;
    private $adminView;
    private $adminNavbar;
    private $pageTitle;

    public function setTemplateRenderer(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function __construct()
    {
        $this->adminView = new AdminView();
        $this->usersModel = new UsersModel();
        $this->adminNavbar = new AdminNavbar();
        $this->adminNavbar->setTitle("admin");
    }

    public function Dashboard(): string
    {
        if (isset($_GET) && isset($_GET["id"])) {
            $this->pageTitle = "User List";
            if ($_GET["id"] == $_SESSION["user"]["id_user"]) {
                $userList = $this->usersModel->getUsers();
                unset($userList[0]["password"]);
                unset($userList[0]["civilite"]);
                unset($userList[0]["address"]);
                unset($userList[0]["tel"]);
                unset($userList[0]["age"]);
                $pageContent = $this->adminView->tableUser($userList);
                
                $this->templateRenderer->setNavbarContent($this->adminNavbar->render());
                return $this->templateRenderer->render($this->pageTitle, $pageContent);
            } else {
                return $this->templateRenderer->render($this->pageTitle, "Accès non autorisé : l'utilisateur n'est pas un utilisateur régulier.");
            }
        }
    }

    private function handleEditUser(){
        return "test";
    }
}
