<?php
class UserViews
{
    private static $userNavBar = <<<HTML
        <div class="container-flui">
            <a class="navbar-brand" href="/">liste</a>
            <a class="navbar-brand" href="create">create</a>
        </div>
    HTML;

    public function __construct()
    {
    }

    public static function renderUserForm(array $userData = []): string
    {
        $name = isset($userData['name']) ? $userData['name'] : '';
        $lastName = isset($userData['lastName']) ? $userData['lastName'] : '';
        $birthday = isset($userData['birthday']) ? $userData['birthday'] : date("Y-m-d");
        $email = isset($userData['email']) ? $userData['email'] : "";
        $address = isset($userData['address']) ? $userData['address'] : "";
        $tel = isset($userData['tel']) ? $userData['tel'] : "";
        $civilite = isset($userData['civilite']) ? $userData['civilite'] : "";
        $submitButton = isset($userData['id']) ? 'Sauvegarder' : 'Créer';

        $civiliteMrChecked = $civilite === "Mr" || empty($userData) ? 'checked' : '';
        $civiliteMmeChecked = $civilite === "Mme" ? 'checked' : '';
        $civiliteMlleChecked = $civilite === "Mlle" ? 'checked' : '';


        $form = <<<HTML
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-6">
            <form method="POST" class="rounded shadow p-4">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Nom</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control form-control-sm" name="name" id="name" value="$name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lastName" class="col-sm-3 col-form-label">Prénoms</label>
                    <div class="col-sm-9">
                        <input type="text" name="lastName" id="lastName" value="$lastName" required class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="birthday" class="col-sm-3 col-form-label">Date de naissance</label>
                    <div class="col-sm-9">
                        <input type="date" name="birthday" id="birthday" value="$birthday" required class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" id="email" value="$email" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="address" class="col-sm-3 col-form-label">Adresse</label>
                    <div class="col-sm-9">
                        <input type="text" name="address" id="address" value="$address" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tel" class="col-sm-3 col-form-label">Tel</label>
                    <div class="col-sm-9">
                        <input type="tel" name="tel" id="tel" value="$tel" class="form-control form-control-sm">
                    </div>
                </div>
                <fieldset>
                    <p class="form-label col-form-label">Sélectionnez la civilité</p>
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
                <div class="d-flex justify-content-center gap-3">
                    <input type="reset" value="Recommencer" class="btn btn-secondary">
                    <input type="submit" value="$submitButton" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
HTML;

        TemplateRenderer::setNavbarContent(self::$userNavBar);
        if (count($userData) > 0) {
            return TemplateRenderer::render("Edit User", $form);
        } else {
            return TemplateRenderer::render("Create User", $form);
        }
    }

    public static function renderUserList(array $data = []): string
    {
        $header = ["id", "nom", "prenom", "civilité", "email", "adresse", "tel", "date de naissance"];
        $userCustomTable = new CustomTable($header, $data);
        $userCustomTable->setBtnEditeState(true);
        $userCustomTable->setBtnDatailState(true);
        $userCustomTable->setBtnDeleteState(true);
        TemplateRenderer::setNavbarContent(self::$userNavBar);
        return TemplateRenderer::render("List", $userCustomTable->renderTable());
    }
}
