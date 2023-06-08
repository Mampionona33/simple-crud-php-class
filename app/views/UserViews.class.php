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
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-6">
        <form method="POST">
            <div class="mb-1 mt-1">
                <label for="name" class="form-label">Nom</label>
                
                    <input type="text" class="form-control form-control-sm" name="name" id="name" value="$name" required>
                
            </div>
                    
            <div class="mb-1 mt-1">
                <label for="lastName" class="form-label">Prénoms</label>
                
                    <input type="text" name="lastName" id="lastName" value="$lastName" required class="form-control form-control-sm">
            </div>
            <div class="mb-1 mt-1">
                <label for="birthday" class="form-label">Date de naissance</label>
                
                    <input type="date" name="birthday" id="birthday" value="$birthday" required class="form-control form-control-sm">
            </div>
            <div class="mb-1 mt-1">
                <label for="email" class="form-label">Email</label>
                
                    <input type="email" name="email" id="email" value="$email" class="form-control form-control-sm">
            </div>
            <div class="mb-1 mt-1">
                <label for="address" class="form-label">Adresse</label>
                
                    <input type="text" name="address" id="address" value="$address" class="form-control form-control-sm">
            </div>
            <div class="mb-1 mt-1">
                <label for="tel" class="form-label">tel</label>
                
                    <input type="tel" name="tel" id="tel" value="$tel" class="form-control form-control-sm">
            </div>
            <fieldset>
                <legend>Sélectionnez la civilité</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="Mr" name="civilite" value="Mr" $civiliteMrChecked>
                    <label class="form-check-label" for="Mr">Mr</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="Mme" name="civilite" value="Mme" $civiliteMmeChecked>
                    <label class="form-check-label" for="Mme">Mme</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="Mlle" name="civilite" value="Mlle" $civiliteMlleChecked>
                    <label class="form-check-label" for="Mlle">Mlle</label>
                </div>
            </fieldset>
            <input type="submit" value="$submitButton">
        </form>
        </div>
    </div>
    HTML;




        if (count($userData) > 0) {
            return TemplateRenderer::render("Edit User", $form);
        } else {
            return TemplateRenderer::render("Create User", $form);
        }
    }

    public static function renderUserList($data = [])
    {
        $header = ["id", "nom", "prenom", "civilité", "email", "adresse", "tel", "date de naissance", "actions"];
        $userCustomTable = new CustomTable($header, $data);
        return TemplateRenderer::render("List", $userCustomTable->renderTable());
    }
}
