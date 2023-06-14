<?php
final class TableVoters
{
    private $btnDetails = false;
    public function renderTable(array $data): string
    {
        $tableHeaders = ["id_voter", "Nom", "Prenoms", "date de naissance", "adresse", "civilité"];
        $tableVisitor = new CustomTable($tableHeaders, $data);
        $this->btnDetails && $tableVisitor->setBtnDatailState($this->btnDetails);
        return $tableVisitor->renderTable();
    }

    function setBtnDetailsVisible(bool $btnDetailsState): void
    {
        $this->btnDetails = $btnDetailsState;
    }

}

?>