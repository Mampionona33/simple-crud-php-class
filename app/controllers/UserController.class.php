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
        $userList = $this->userModels->getUser();
        $tempUserList = [];
        foreach ($userList as $user) {
            $tempAge = $user["age"];
            unset($user["age"]);
            $user["age"] = $this->ageInSecToBirthday($tempAge);
            $tempUserList[] = $user;
        }
        echo UserViews::renderUserList($tempUserList);
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
            $data["age"] = $this->birthdayToAge($_POST["birthday"]);

            unset($data["name"], $data["lastName"], $data["birthday"]);

            if ($this->userModels->createUser($data)) {
                TemplateRenderer::setMessage("The user creates successfully.");
                header("Refresh:3, /");
            } else {
                TemplateRenderer::setError("Error on creatting user");
            }
        }
        echo UserViews::renderUserForm();
    }

    private function birthdayToAge($birthdayInput): int
    {
        $age = 0;
        $now = new DateTime();
        $birthD = new DateTime($birthdayInput);
        $diff = $now->diff($birthD);
        $age = $diff->y * 31536000 + // nombre de secondes dans une année
            $diff->m * 2592000 +  // nombre de secondes dans un mois (moyenne de 30 jours)
            $diff->d * 86400 +    // nombre de secondes dans un jour
            $diff->h * 3600 +      // nombre de secondes dans une heure
            $diff->i * 60 +        // nombre de secondes dans une minute
            $diff->s;              // nombre de secondes

        return $age;
    }

    private function ageInSecToBirthday(int $age)
    {
        $currentTimestamp = time();
        $birthTimestamp = $currentTimestamp - $age;
        $birthDate = date('Y-m-d H:i:s', $birthTimestamp);
        return $birthDate;
    }
}
