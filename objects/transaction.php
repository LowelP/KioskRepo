<?php


class Transaction{

    private $conn;
    private $table_name = "transactions"; 


    public $id;
    public $department_id;
    public $category_id;
    public $name;
    public $created_by;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function read($did){
        
        $query = "SELECT 
                    id, name
                    FROM 
                    " . $this->table_name . "
                    WHERE department_id = $did";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }
}

?>