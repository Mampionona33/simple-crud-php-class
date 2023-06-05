<?php
    function connect_db(){
        $db_user ="root";
        $db_password =  "pass";
        $dbname =  "project_data_base";
        $host =  "mysql";
        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
    
        try {
            $conn = new PDO($dsn, $db_user, $db_password);
    
            // Set PDO attributes
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
            return $conn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }   
    }
?>