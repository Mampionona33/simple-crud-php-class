<?php
class UserModel
{
    private $out;
    private $col =  [
        [
            'name' => 'id_task',
            'type' => 'INT',
            'required' => true,
            'auto_increment' => true,
        ],
        [
            'name' => 'task_name',
            'type' => 'VARCHAR(255)',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'num_task',
            'type' => 'VARCHAR(255)',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'id_type_task',
            'type' => 'INT',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'nbr_before',
            'type' => 'INT default 0',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'nbr_after',
            'type' => 'INT default 0',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'id', // user Id
            'type' => 'INT',
            'required' => true,
            'auto_increment' => false,
        ],
        [
            'name' => 'start_time',
            'type' => 'DATETIME',
            'required' => false,
            'auto_increment' => false,
        ],
        [
            'name' => 'total_duration',
            'type' => 'INT default 0',
            'required' => false,
            'auto_increment' => false,
        ],
    ];

    private $tableManipulator;

    public function __construct()
    {
        $this->tableManipulator = new TableManipulator();
        $this->tableManipulator->createTable("users",$this->col);
    }

    private function getUser(){

    }

    
}
