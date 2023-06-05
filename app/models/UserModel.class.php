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
            'name' => 'adresse',
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

    public function __construct()
    {
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable("users", $this->col);
    }

    private function getUser()
    {
    }
}
