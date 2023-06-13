<?php
class AdminView
{
    public function tableUser(array $data = []): string
    {
        $header = ["id_user", "nom", "prenom", "email","role"];
        $tableUser = new CustomTable($header, $data);
        $tableUser->setBtnEditeState(true);
        $tableUser->setBtnDatailState(true);
        $tableUser->setBtnDeleteState(true);
        $tableUser->setSearchBarVisible(true);
        $tableUser->setAddBtnVisible(true);
        $templateRenderer = new TemplateRenderer();
        return $templateRenderer->render("Dashboard", $tableUser->renderTable());
    }
}
