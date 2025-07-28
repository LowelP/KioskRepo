<?php

class Queueconfig{

    private $conn;
    private $table_name = "queue_configurations";


    public $id;
    public $department_id;
    public $ideal_wait_time;
    public $booking_day_count;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }


    function getBookslot($did){
        
        $query = "SELECT id, booking_day_count
                    FROM " . $this->table_name . " 
                    WHERE
                    department_id = :did";
        
        $stmt = $this->conn->prepare($query);

        $stmt->BindParam(":did", $did);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
           return (int) $row['booking_day_count'];
        }
        return false;
    }
}




?>