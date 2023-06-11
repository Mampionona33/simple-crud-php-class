<?php
class AdminController
{
    private $uri;
    private $usersModel;
    private $templateRenderer;
    private $adminView;


    public function setTemplateRenderer($templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function __construct()
    {
        $this->adminView = new AdminView();
        $this->usersModel = new UsersModel();
    }

    public function Dashboard(): string
    {
        if (isset($_GET) && isset($_GET["id"])) {
            if ($_GET["id"] == $_SESSION["user"]["id_user"]) {
                $userList = $this->usersModel->getUser();
                unset($userList[0]["password"]);
                $pageContent = $this->adminView->tableUser($userList);
                return $this->templateRenderer->render("Dashboard", $pageContent);
            } else {
                return $this->templateRenderer->render("Dashboard", "Accès non autorisé : l'utilisateur n'est pas un utilisateur régulier.");
            }
        }
    }
}
