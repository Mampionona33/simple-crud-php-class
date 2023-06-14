<?php
final class TableVoters
{
    private $btnDetails = false;
    private $searchBar = true;
    public function renderTable(array $data): string
    {
        $tableHeaders = ["id_voter", "Nom", "Prenoms", "date de naissance", "adresse", "civilité"];
        $tableVisitor = new CustomTable($tableHeaders, $data);
        $this->btnDetails && $tableVisitor->setBtnDatailState($this->btnDetails);
        $this->searchBar && $tableVisitor->setSearchBarVisible($this->searchBar);
        return $tableVisitor->renderTable();
    }

    function setBtnDetailsVisible(bool $btnDetailsState): void
    {
        $this->btnDetails = $btnDetailsState;
    }

    function setSearchBarVisible(bool $searchBarState): void
    {
        $this->searchBar = $searchBarState;
    }

}

?>