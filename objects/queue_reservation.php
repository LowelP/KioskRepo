<?php

class QueueReservation{


    private $conn;
    private $table_name = "queue_reservations";

    public $id;
    public $full_name;
    public $queue_number;
    public $department_id;
    public $transaction_id;
    public $user_type;
    public $reservation_date;
    public $reservation_time;
    public $queue_reservation_id;
    public $booking_type;

    public function __construct($db){
        $this -> conn= $db;
    }

    function create(){

            $query = "INSERT INTO " . $this->table_name . "
                        SET
                        full_name=:full_name,
                        department_id=:department_id,
                        transaction_id=:transaction_id,
                        queue_reservation_id = :queue_reservation_id,
                        user_type=:user_type,
                        source=:source";

            $stmt = $this->conn->prepare( $query );

            $this->full_name = htmlspecialchars(strip_tags($this->full_name));
            $this->department_id = htmlspecialchars(strip_tags($this->department_id));
            $this->queue_reservation_id = htmlspecialchars(strip_tags($this->queue_reservation_id));
            $this->user_type = htmlspecialchars(strip_tags($this->user_type));
            $this->transaction_id = htmlspecialchars(strip_tags($this->transaction_id));
            $this->source = htmlspecialchars(strip_tags($this->source));

            $stmt->bindParam(':full_name', $this->full_name);
            $stmt->bindParam(':department_id', $this->department_id);
            $stmt->bindParam(':queue_reservation_id', $this->queue_reservation_id);
            $stmt->bindParam(':user_type', $this->user_type);
            $stmt->bindParam(':transaction_id', $this->transaction_id);
            $stmt->bindParam(':source', $this->source);

            if ($stmt->execute()){
                return true;
            }
            else {
                return false;
            }
            
            





    }

}

?>