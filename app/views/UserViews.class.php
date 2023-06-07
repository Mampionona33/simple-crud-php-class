<?php
class UserViews
{

    public function __construct()
    {
    }

    public static function renderUserForm($userData = [])
    {
        $name = isset($userData['name']) ? $userData['name'] : '';
        $lastName = isset($userData['lastName']) ? $userData['lastName'] : '';
        $birthday = isset($userData['birthday']) ? $userData['birthday'] : date("Y-m-d");
        $email = isset($userData['email']) ? $userData['email'] : "";
        $address = isset($userData['address']) ? $userData['address'] : "";
        $tel = isset($userData['tel']) ? $userData['tel'] : "";
        $civilite = isset($userData['civilite']) ? $userData['civilite'] : "";
        $submitButton = isset($userData['id']) ? 'Save' : 'Create';

        $civiliteMrChecked = $civilite === "Mr" || empty($userData) ? 'checked' : '';
        $civiliteMmeChecked = $civilite === "Mme" ? 'checked' : '';
        $civiliteMlleChecked = $civilite === "Mlle" ? 'checked' : '';


        $form = <<<HTML
            <form method="POST">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="$name" required>
                <label for="lastName">Prénoms</label>
                <input type="text" name="lastName" id="lastName" value="$lastName" required>
                <label for="birthday">Date de naissance</label>
                <input type="date" name="birthday" id="birthday" value="$birthday" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="$email">
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="$address">
                <label for="tel">tel</label>
                <input type="tel" name="tel" id="tel" value="$tel">
                <fieldset>
                    <legend>Sélectionnez la civilité</legend>
                    <div>
                    <input type="radio" id="Mr" name="civilite" value="Mr" $civiliteMrChecked>
                    <label for="Mr">Mr</label>
                </div>
                <div>
                    <input type="radio" id="Mme" name="civilite" value="Mme" $civiliteMmeChecked>
                    <label for="Mme">Mme</label>
                </div>
                <div>
                    <input type="radio" id="Mlle" name="civilite" value="Mlle" $civiliteMlleChecked>
                    <label for="Mlle">Mlle</label>
                </div>
                </fieldset>
                <input type="submit" value="$submitButton">
            </form>
        HTML;

        if (count($userData) > 0) {
            return TemplateRenderer::render("Edit User", $form);
        } else {
            return TemplateRenderer::render("Create User", $form);
        }
    }

    public static function renderUserList($data = [])
    {
        $header = ["id", "nom", "prenom", "date de naissance", "civilité", "adresse", "email", "tel"];
        $userCustomTable = new CustomTable($header, $data);
        return TemplateRenderer::render("List", $userCustomTable->renderTable());
    }
}
