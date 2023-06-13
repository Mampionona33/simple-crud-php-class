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

    public function render(): string
    {
        $title = $this->renderTitle();
        return <<<HTML
            <div class="container-fluid">
                $title
                <div class="d-flex justify-content-end">
                    <a class="navbar-brand" href="/logout">log out</a>
                </div>
            </div>
        HTML;
    }
}
