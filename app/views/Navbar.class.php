<?php
class Navbar
{
    private $options;
    private $title;

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    private function renderTitle()
    {
        if($this->title){
            return '<div class="text-light fs-4">'.$this->title.'</div>';
        }
    }

    private function logButton() : string {
        if(!isset($_SESSION["user"])){
            return '<a class="navbar-brand" href="/login">login</a>';
        }
        return '<a class="navbar-brand" href="/logout">log out</a>';
    }

    public function render(): string
    {
        $logButton = $this->logButton();
        $title = $this->renderTitle();
        return <<<HTML
            <div class="container-fluid">
                $title
                <div class="d-flex justify-content-end">
                   $logButton
                </div>
            </div>
        HTML;
    }
}
