<?php
class CustomTable
{
    private $header;
    private $data;
    private $btnEditState = false;
    private $btnDeleteState;
    private $btnDetailsState = false;
    private $showColId = false;

    public function __construct(array $header = [], $data = [])
    {
        $this->header = $header;
        $this->data = $data;
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

    private function renderActionBtn(mixed $id, string $btnType): string
    {
        $output = '';
        if (preg_match('/edit/i', $btnType)) {
            $output .= '<button type="button" id="btnEdit' . $id . '" name="edit" data-id="' . $id . '" class="btn btn-primary">Edit</button>';
        }
        if (preg_match('/details/i', $btnType)) {
            $output .= '<button type="button" id=btnDetails' . $id . ' name="details" data-id=' . $id . ' class="btn btn-primary">Details</button>';
        }
        if (preg_match('/delete/i', $btnType)) {
            $output .= '<button type="button" id=btnDelete' . $id . ' name="delete" data-id=' . $id . ' class="btn btn-danger">Delete</button>';
        }
        return $output;
    }

    public function renderTable(): string
    {

        $btnEdit = '<button class="btn btn-primary">Edit</button>';
        $tableHeaders = "";

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
                    $tableBody .= '<td class="d-flex column-gap-3">';
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
        <div class="d-flex align-items-center justify-content-center vh-100 ">
            <div class="container">
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
        HTML;
    }
}
