<?php
class OperatorController extends VisitorController
{
    private $pathname;
    private $role;
    private $id;

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

    public function getVoters(array $columns = array(), $condition = ""): string
    {
        // var_dump($this->pathname);
        if ($this->role === "operator") {
            if (strpos($this->pathname, '/operator/dashboard') !== false) {
                // Le chemin correspond à '/operator/dashboard'
                if (isset($_GET["id"]) && $_GET["id"] == $this->id) {
                    // L'ID dans l'URL correspond à l'ID de l'utilisateur
                    $this->tableVoters->setBtnEditVisible(true);
                    $this->tableVoters->setAddBtnVisible(true);
                    $this->tableVoters->setBtnDeleteVisible(true);
                    return parent::getVoters($columns, $condition);
                } else {
                    // L'ID dans l'URL est invalide
                    $this->templateRenderer->setError("Error", "User not authenticated");
                    return $this->templateRenderer->render("Error", "User not authenticated");
                }
            }
        }

        return "Error: Unable to get voters";
    }
}
