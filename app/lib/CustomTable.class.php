<?php
class CustomTable
{
    private $header;
    private $data;
    private $btnEditState = false;
    private $btnDeleteState;
    private $btnDetailsState = false;
    private $showColId = false;
    private $searchBarState = false;
    private $addButtonState = false;

    private $tableName;

    public function __construct(string $tableName, array $header = [], $data = [])
    {
        $this->header = $header;
        $this->data = $data;
        $this->tableName = $tableName;
    }

    public function setBtnEditeState(bool $btnEditState = false): void
    {
        $this->btnEditState = $btnEditState;
    }

    public function setBtnDatailState(bool $btnDetailsState = false): void
    {
        $this->btnDetailsState = $btnDetailsState;
    }

    public function setBtnDeleteState(bool $btnDeleteState = false): void
    {
        $this->btnDeleteState = $btnDeleteState;
    }

    public function showColumnId(bool $showColId): void
    {
        $this->showColId = $showColId;
    }

    public function setSearchBarVisible(bool $searchBarState): void
    {
        $this->searchBarState = $searchBarState;
    }

    public function setAddBtnVisible(bool $addButtonState): void
    {
        $this->addButtonState = $addButtonState;
    }

    private function renderActionBtn(mixed $id, string $btnType): string
    {
        $output = '';
        if (preg_match('/edit/i', $btnType)) {
            $output .= '<button type="button" id="btn-edit-' . $id . '" name="edit" data-id="' . $id . '" data-api-path="' . $this->tableName . '" class="btn btn-primary">Modifier</button>';
        }
        if (preg_match('/details/i', $btnType)) {
            $output .= '<button type="button" id=btn-details-' . $id . ' name="details" data-id=' . $id . ' data-api-path="' . $this->tableName . '" class="btn btn-info">Details</button>';
        }
        if (preg_match('/delete/i', $btnType)) {
            $output .= '<button type="button" data-api-path="' . $this->tableName . '" id=btn-delete-' . $id . ' name="delete" data-id=' . $id . ' class="btn btn-danger">Supprimer</button>';
        }
        return $output;
    }

    private function renderSearchBar()
    {
        if ($this->searchBarState) {
            return '
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            ';
        }
        return null;
    }

    private function renderAddButton()
    {
        if ($this->addButtonState) {
            return '
                <button id="table-btn-add" class="btn btn-primary">Ajouter</button>
            ';
        }
        return null;
    }

    public function renderTable(): string
    {

        $btnEdit = '<button class="btn btn-primary">Edit</button>';
        $tableHeaders = "";
        $searchBar = $this->renderSearchBar();
        $addBtn = $this->renderAddButton();

        if ($this->showColId) {
            foreach ($this->header as $key => $value) {
                $tableHeaders .= "<th>$value</th>";
            }
        } else {
            unset($this->header[0]);
            foreach ($this->header as $key => $value) {
                $tableHeaders .= "<th>$value</th>";
            }
        }

        if ($this->btnEditState || $this->btnDeleteState || $this->btnDetailsState) {
            $tableHeaders .= "<th>actions</th>";
        }

        $tableBody = "";

        if (count($this->data) > 0) {
            foreach ($this->data as $key => $rows) {
                $id = array_values($rows)[0];
                $tableBody .= "<tr>";

                if ($this->showColId) {
                    foreach ($rows as $key => $contents) {
                        $tableBody .= "<td>$contents</td>";
                    }
                } else {

                    foreach (array_slice($rows, 1) as $contents) {
                        $tableBody .= "<td>$contents</td>";
                    }
                }

                if ($this->btnEditState || $this->btnDetailsState || $this->btnDeleteState) {
                    $tableBody .= '<td class="d-flex flex-wrap gap-3 justify-content-center">';
                    if ($this->btnEditState) {
                        $tableBody .= $this->renderActionBtn($id, "edit");
                    }
                    if ($this->btnDetailsState) {
                        $tableBody .= $this->renderActionBtn($id, "details");
                    }
                    if ($this->btnDeleteState) {
                        $tableBody .= $this->renderActionBtn($id, "delete");
                    }
                    $tableBody .= "</td>";
                }
                $tableBody .= "</tr>";
            }
        } else {
            $tableBody .= "<tr>";
            $tableBody .= "<td colspan=" . count($this->header) . " >No data Found</td>";
            $tableBody .= "</tr>";
        }

        return <<<HTML
        <div class="d-flex flex-column align-items-center justify-content-center vh-100">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    $searchBar
                    $addBtn
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped shadow-sm">
                        <thead>
                            <tr class="text-uppercase table-dark">$tableHeaders</tr>
                        </thead>
                        <tbody>
                            $tableBody
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        HTML;
    }


}