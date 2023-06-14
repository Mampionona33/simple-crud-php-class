<?php
final class TableVoters
{
    private $btnDetails = false;
    private $searchBar = true;
    private $btnEdit = false;
    private $btnAdd = false;
    private $btnDelete = false;

    public function renderTable(array $data): string
    {
        $tableHeaders = ["id_voter", "Nom", "Prenoms", "date de naissance", "adresse", "civilité"];
        $tableVisitor = new CustomTable($tableHeaders, $data);
        $this->btnDetails && $tableVisitor->setBtnDatailState($this->btnDetails);
        $this->searchBar && $tableVisitor->setSearchBarVisible($this->searchBar);
        $this->btnAdd && $tableVisitor->setAddBtnVisible($this->btnAdd);
        $this->btnDelete && $tableVisitor->setBtnDeleteState($this->btnDelete);
        $this->btnEdit && $tableVisitor->setBtnEditeState($this->btnEdit);
        return $tableVisitor->renderTable();
    }

    function setBtnDetailsVisible(bool $btnDetailsState): void
    {
        $this->btnDetails = $btnDetailsState;
    }
    function setBtnDeleteVisible(bool $btnDeleteState): void
    {
        $this->btnDelete = $btnDeleteState;
    }
    function setBtnEditVisible(bool $btnEditState): void
    {
        $this->btnEdit = $btnEditState;
    }

    function setAddBtnVisible(bool $btnAddState): void
    {
        $this->btnAdd = $btnAddState;
    }

    function setSearchBarVisible(bool $searchBarState): void
    {
        $this->searchBar = $searchBarState;
    }

}

?>