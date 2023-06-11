<?php
class UsersModel
{
    private $out;
    private $col =  [
        [
            'name' => 'id_user',
            'type' => 'INT',
            'required' => true,
            'auto_increment' => true,
        ],
        [
            'name' => 'nom',
            'type' => 'VARCHAR(50)',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'prenom',
            'type' => 'VARCHAR(50)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'age',
            'type' => 'BIGINT',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'civilite',
            'type' => 'ENUM',
            'values' => ['Mr', 'Mme', 'Mlle'],
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'email',
            'type' => 'VARCHAR(50)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'address',
            'type' => 'VARCHAR(50)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'tel',
            'type' => 'VARCHAR(50)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'password',
            'type' => 'VARCHAR(255)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'role',
            'type' => 'ENUM',
            'values' => ['operator', 'admin'],
            'required' => true,
            'auto_increment' => false,
        ],
    ];

    private $tableManipulator;
    private $dataManipulator;
    private static $nomTable = "users_";

    public function __construct()
    {
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable(self::$nomTable, $this->col);
        $this->dataManipulator = new DataManipulator();
    }

    public function getUser()
    {
        return  $this->dataManipulator->getData(self::$nomTable);
    }

    public function getUserByEmail(array $data): array
    {
        $condition = "email = '" . $data["email"] . "'";
        return $this->dataManipulator->getData(self::$nomTable, [], $condition);
    }

    public function createUser($data)
    {
        return $this->dataManipulator->createData(self::$nomTable, $data);
    }
}
