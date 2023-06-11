<?php
class LoginViews
{
    private $templateRenderer;

    public function __construct()
    {
    }

    public function setTemplateRenderer($templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }


    private function loginForm(): string
    {
        return <<<HTML
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="">
                <form method="POST" class="rounded shadow p-4">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label" >Identifiant</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="exemple@email.com" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label" >Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control form-control-sm" name="password" id="password"  required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center gap-3">
                        <input type="submit" value="Login" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
        HTML;
    }

    public function render()
    {
        return $this->templateRenderer->render("Login", $this->loginForm());
    }
}
