<?php

class QueueNumber{
    
    private $conn;
    private $table_name = "queue_number";

    public $id;
    public $department_id;
    public $last_queue_number;
    public $queue_reservation_id;

    public function __construct($db){
        $this -> conn= $db;
    }

    // function UpdateQueueNumber($did){

    //     $query = "UPDATE ". $this->table_name . "
    //             SET 
    //             last_queue_number = last_queue_number + 1,
    //             queue_reservation_id = :queue_reservation_id
    //             WHERE department_id = :department_id";
        
    //     $stmt = $this->conn->prepare($query);

    //     $this->queue_reservation_id = htmlspecialchars(strip_tags($this->queue_reservation_id));
        
    //     $stmt->bindParam(":queue_reservation_id", $this->queue_reservation_id);
    //     $stmt->bindParam(":department_id", $did, PDO::PARAM_INT);

    //     if ($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }


function UpdateQueueNumber($did) {
    // 1. Fetch current last queue number
    $query = "SELECT last_queue_number FROM " . $this->table_name . " 
              WHERE department_id = :department_id";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":department_id", $did, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $last = isset($row['last_queue_number']) ? $row['last_queue_number'] : 0;
    $next = $last + 1;

    // 2. Sanitize reservation ID
    $this->queue_reservation_id = htmlspecialchars(strip_tags($this->queue_reservation_id));

    // 3. Current date and time
    $today = date('Y-m-d H:i:s'); // Example: 2025-08-11 12:34:56

    // 4. Update new queue number, reservation ID, and date
    $update = "UPDATE " . $this->table_name . " 
               SET 
                   last_queue_number = :next,
                   queue_reservation_id = :queue_reservation_id,
                   last_update_date = :last_update_date
               WHERE department_id = :department_id";

    $updateStmt = $this->conn->prepare($update);
    
    $updateStmt->bindParam(":next", $next, PDO::PARAM_INT);
    $updateStmt->bindParam(":queue_reservation_id", $this->queue_reservation_id);
    $updateStmt->bindParam(":last_update_date", $today);
    $updateStmt->bindParam(":department_id", $did, PDO::PARAM_INT);

    // 5. Execute and store in object if successful
    if ($updateStmt->execute()) {
        $this->last_queue_number = $next;
        return true;
    }

    return false;
}



}



?>