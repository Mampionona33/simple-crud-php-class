<?php
class UsersModel
{
    private $out;
    private $col = [
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
            'name' => 'birthday',
            'type' => 'Date',
            'required' => true,
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
    private $nomTable = "Users";

    public function __construct()
    {
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable($this->nomTable, $this->col);
        $this->dataManipulator = new DataManipulator();
    }

    public function getUsers()
    {
        return $this->dataManipulator->getData($this->nomTable);
    }

    public function getUser($userId)
    {
        $condition = "id_user = '$userId'";
        $result = $this->dataManipulator->getData($this->nomTable, [], $condition);
        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function getUserByEmail(array $data): array
    {
        $condition = "email = '" . $data["email"] . "' AND password = '" . $data["password"] . "'";
        return $this->dataManipulator->getData($this->nomTable, [], $condition);
    }

    public function createUser($data)
    {
        return $this->dataManipulator->createData($this->nomTable, $data);
    }

    public function getTotalCountByRole(string $role): int
    {
        $condition = "role = '$role'";
        return $this->dataManipulator->getCount($this->nomTable, $condition);
    }
}
