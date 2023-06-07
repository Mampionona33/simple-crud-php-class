<?php
class CustomTable
{
    private $header;
    private $data;
    public function __construct($header = [], $data = [])
    {
        $this->header =  $header;
        $this->data = $data;
    }

    public function renderTable()
    {
        $tableHeaders = "";
        foreach ($this->header as $key => $value) {
            $tableHeaders .= "<th>$value</th>";
        }

        $tableBody = "";

        if (count($this->data) > 0) {
            foreach ($this->data as $key => $rows) {
                $tableBody .= "<tr>";
                foreach ($rows as $key => $contents) {
                    $tableBody .= "<td>$contents</td>";
                }
                $tableBody .= "</tr>";
            }
        } else {
            $tableBody .= "<tr>";
            $tableBody .= "<td colspan=" . count($this->header) . " >No data Found</td>";
            $tableBody .= "</tr>";
        }

        return <<<HTML
        <table>
            <thead>
                <tr>$tableHeaders</tr>
            </thead>
            <tbody>
                $tableBody
            </tbody>
        </table>
        HTML;
    }
}
