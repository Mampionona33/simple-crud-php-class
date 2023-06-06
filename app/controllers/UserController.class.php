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

    function show_user_list()
    {
    }

    public static function show_user_form_create()
    {
        if(isset($_POST["name"])){
            TemplateRenderer::setMessage("user boom");
        }
        echo UserViews::renderUserForm();
    }
}
