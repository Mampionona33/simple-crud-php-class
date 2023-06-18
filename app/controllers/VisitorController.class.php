<?php
class VisitorController extends AbstractUserController
{

    protected $votersModel;
    protected $templateRenderer;
    protected $tableVoters;
    protected $navbar;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->votersModel = new VotersModel();
        $this->templateRenderer = $templateRenderer;
        $this->tableVoters = new TableVoters;
        $this->navbar = new Navbar();
    }
    public function getVoter($voterId): string
    {
        return "test";
    }

    public function getVoters(array $columns = array(), $condition = ""): string
    {
        // Create table voters
        $listUsers = $this->votersModel->getVoters($columns, $condition);
        $this->tableVoters->setBtnDetailsVisible(true);
        $this->templateRenderer->setNavbarContent($this->navbar->render());
        $this->templateRenderer->setBodyContent($this->tableVoters->renderTable($listUsers));
        return $this->templateRenderer->render("List électeurs");
    }

    protected function getNavbar(): string
    {
        return $this->navbar->render();
    }
}
