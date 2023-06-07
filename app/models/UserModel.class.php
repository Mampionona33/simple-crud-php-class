<?php
class UserModel
{
    private $out;
    private $col =  [
        [
            'name' => 'id',
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
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'civilite',
            'type' => 'ENUM',
            'values' => ['Mr', 'Mme', 'Mlle'],
            'required' => true,
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
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'tel',
            'type' => 'VARCHAR(50)',
            'required' => false,
            'auto_increment' => false,
        ]
    ];

    private $tableManipulator;
    private $dataManipulator;
    private static $nomTable = "users";
    public function __construct()
    {
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable("users", $this->col);
        $this->dataManipulator = new DataManipulator();
    }

    public function getUser()
    {
        $userList = $this->dataManipulator->getData(self::$nomTable);
        return $userList;
    }

    public function createUser($data)
    {
        return $this->dataManipulator->createData(self::$nomTable, $data);
    }
}
