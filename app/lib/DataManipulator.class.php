<?php

require_once "./connect_db.php";

class DataManipulator
{
    private $db;

    public function __construct()
    {
        $this->db = connect_db();
    }

    public function createData($tableName, $data)
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $tableName ($fields) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        try {
            $stmt->execute();
            return $data;
        } catch (PDOException $e) {
            echo "Erreur lors de la création des données : " . $e->getMessage();
            exit();
        }
    }

    public function getData($tableName, $columns = [], $condition = "")
    {
        $query = "SELECT";

        // Si la liste de colonnes est vide, sélectionner toutes les colonnes avec *
        if (empty($columns)) {
            $query .= " *";
        } else {
            // Sinon, ajouter les colonnes à la requête
            $query .= " " . implode(", ", $columns);
        }

        // Ajouter la table à la requête
        $query .= " FROM " . $tableName;

        // Si une condition est spécifiée, l'ajouter à la requête
        if (!empty($condition)) {
            $query .= " WHERE " . $condition;
        }

        $stmt = $this->db->prepare($query);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des données : " . $e->getMessage();
            exit();
        }
    }
}
?>
