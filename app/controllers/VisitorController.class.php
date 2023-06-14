<?php
class VisitorController extends AbstractUserController
{

    private $votersModel;
    private $templateRenderer;
    private $tableVoters;

    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->votersModel = new VotersModel();
        $this->templateRenderer = $templateRenderer;
        $this->tableVoters = new TableVoters;

    }
    public function getVoter($voterId): string
    {
        return "test";
    }

    public function getVoters(array $columns = array(), $condition = ""): string
    {
        // Create table voters
        $listUsers = $this->votersModel->getUsers($columns, $condition);
        $this->tableVoters->setBtnDetailsVisible(true);
        $outpoutPage = $this->templateRenderer->render("List électeurs", $this->tableVoters->renderTable($listUsers));
        return $outpoutPage;
    }
}