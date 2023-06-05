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
        $age = isset($userData['age']) ? $userData['age'] : date("Y-m-d");
        $email = isset($userData['email']) ? $userData['email'] : "";
        $address = isset($userData['address']) ? $userData['address'] : "";
        $civilite = isset($userData['civilite']) ? $userData['civilite'] : "";
        $submitButton = isset($userData['id']) ? 'Save' : 'Create';

        $form = <<<HTML
            <form method="POST">
                <label for="name">Nom</label>
                <input type="text" name="name" id="name" value="$name" required>
                <label for="lastName">Prénoms</label>
                <input type="text" name="lastName" id="lastName" value="$lastName" required>
                <label for="age">Date de naissance</label>
                <input type="date" name="age" id="age" value="$age" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="$email">
                <label for="address">Adresse</label>
                <input type="text" name="address" id="address" value="$address">
                <fieldset>
                    <legend>Sélectionnez la civilité</legend>
                    <div>
                        <input type="radio" id="Mr" name="civilite" value="Mr" $civilite>
                        <label for="Mr">Mr</label>
                    </div>
                    <div>
                        <input type="radio" id="Mme" name="civilite" value="Mme" $civilite>
                        <label for="Mme">Mme</label>
                    </div>
                    <div>
                        <input type="radio" id="Mlle" name="civilite" value="Mlle" $civilite>
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
}
