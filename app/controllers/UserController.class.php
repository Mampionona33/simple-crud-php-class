<?php
    class UserController{
        private $users;
        private $userModels;
        private $templateRenderer;
        public function __construct()
        {
            $this->userModels = new UserModel();
            $this->templateRenderer = new TemplateRenderer();
        }

        function show_user_list(){
          
        }
    }
?>