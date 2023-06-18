<?php
class VotersModel
{
    private $tableName = "Voters";
    private $columns = [
        [
            'name' => 'id_voter',
            'type' => 'INT',
            'required' => true,
            'auto_increment' => true,
        ],
        [
            'name' => 'name',
            'type' => 'VARCHAR(100)',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'last_name',
            'type' => 'VARCHAR(100)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'birthday',
            'type' => 'Date',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'adresse',
            'type' => 'VARCHAR(100)',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'civility',
            'type' => 'ENUM',
            'values' => ['Mr', 'Mme', 'Mlle'],
            'required' => false,
            'auto_increment' => false,
        ],
    ];
    private $tableManipulator;
    private $dataManipulator;

    public function __construct()
    {
        // create table Voter if it not existe
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable($this->tableName, $this->columns);
        $this->dataManipulator = new DataManipulator();
    }

    public function getVoters(array $columns = [], string $condition = ""): array
    {
        return $this->dataManipulator->getData($this->tableName, $columns, $condition);
    }

    public function getVoter($voterId): array
    {
        $condition = "id_voter = '$voterId'";
        return $this->dataManipulator->getData($this->tableName, [], $condition);
    }

    public function createVoter(array $data)
    {
        return $this->dataManipulator->createData($this->tableName, $data);
    }

    public function updateVoter(array $data, $id_key, $id_value)
    {
        return $this->dataManipulator->updateData($this->tableName, $data, $id_key, $id_value);
    }
}
