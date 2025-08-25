<?php

class Department{

    private $conn;
    private $table_name = "departments";


    public $id;
    public $name;
    public $description;
    public $available_slots;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }

    function deductSlot($did){

        $query = "UPDATE ". $this->table_name . "
                    SET 
                    available_slots = available_slots - 1
                    WHERE id = :id";

        $stmt= $this->conn->prepare($query);

        $stmt->bindParam(":id", $did, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getBookslot($did){
        
        $query = "SELECT id, available_slots
                    FROM " . $this->table_name . " 
                    WHERE
                    id = :did";
        
        $stmt = $this->conn->prepare($query);

        $stmt->BindParam(":did", $did);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
           return (int) $row['available_slots'];
        }
        return false;
    }

    


}

?>