<?php
class UserController
{
    private $users;
    private $userModels;
    private $templateRenderer;
    private $userViews;

    public function __construct()
    {
        $this->userModels = new UserModel();
        $this->templateRenderer = new TemplateRenderer();
    }

    public function show_user_list()
    {
    }

    public function show_user_form_create()
    {
        if (
            isset($_POST["name"]) &&
            isset($_POST["lastName"]) &&
            isset($_POST["birthday"]) &&
            isset($_POST["address"])
        ) {
            $data = $_POST;
            $data["nom"] = $_POST["name"];
            $data["prenom"] = $_POST["lastName"];

            $now = new DateTime("now");
            $birthDay = new DateTime($_POST["birthday"]);
            $diff = $now->diff($birthDay);

            $ageInSeconds = $diff->y * 31536000 + // nombre de secondes dans une année
                $diff->m * 2592000 +  // nombre de secondes dans un mois (moyenne de 30 jours)
                $diff->d * 86400 +    // nombre de secondes dans un jour
                $diff->h * 3600 +      // nombre de secondes dans une heure
                $diff->i * 60 +        // nombre de secondes dans une minute
                $diff->s;              // nombre de secondes

            $data["age"] = $ageInSeconds;

            unset($data["name"], $data["lastName"], $data["birthday"]);

            if ($this->userModels->createUser($data)) {
                TemplateRenderer::setMessage("user boom");
                header("Refresh:2, /create");
            } else {
                TemplateRenderer::setError("Error on creatting user");
            }
        }
        echo UserViews::renderUserForm();
    }
}
