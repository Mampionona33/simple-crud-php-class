<?php
class UserModel
{
    private $out;
    public function __construct()
    {
    }
    public function render()
    {
        return <<<HTML
            <p>test</p>
        HTML;
    }
}
