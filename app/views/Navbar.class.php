<?php
class Navbar
{
    private $options;
    private  $navbar = <<<HTML
        <div class="container-flui">
            <a class="navbar-brand" href="/logout">log out</a>
        </div>
    HTML;

    public function render()
    {
        return $this->navbar;
    }
}
