<?php

include_once "../config/database.php";
include_once "../objects/transaction.php";
include_once "../objects/queue_reservation.php";
include_once "../objects/department.php";
include_once "../objects/queue_number.php";

$database = new Database();
$db = $database->getConnection();

$transaction = new Transaction ($db);
$queue_reservation = new QueueReservation($db);
$departments   = new Department($db);
$queue_number = new QueueNumber($db);


$did = isset($_GET['did']) ? $_GET['did']: die ("ERROR: 404 Not Found");
$department=null;
if ($did==1) {
  $department = "Cashier";

}else if ($did==2) {
  $department = "Admission";
}else if ($did==3) {
  $department= "MIS";
}else if ($did==4){
  $department= "Registrar";
}else{
  $department= "Department Not Available";
}

$page_title = $department;
include_once "layout_head.php";


if ($_POST) {

    // Generate prefix based on department
    switch ($did) {
        case 1: $prefix = "C"; break;
        case 2: $prefix = "A"; break;
        case 3: $prefix = "M"; break;
        case 4: $prefix = "R"; break;
        default: $prefix = "X"; break;
    }

    // Generate queue reservation ID
    $queue_reservation_id = $prefix . rand(1000, 9999);

    // Fill in reservation fields
    $queue_reservation->full_name = $_POST['full_name'];
    $queue_reservation->department_id = $did;
    $queue_reservation->queue_reservation_id = $queue_reservation_id;
    $queue_reservation->transaction_id = $_POST['transaction_id'];
    $queue_reservation->user_type = $_POST['user_type'];
    $queue_reservation->source = "By Kiosk";

    $queue_number->queue_reservation_id = $queue_reservation_id;

    // Save reservation
    if ($queue_reservation->create()) {
        // Update queue number
        $queue_number->UpdateQueueNumber($did);

        // Deduct slot
        $departments->deductSlot($did);

        // Get new queue number
        $actual_queNum = $queue_number->last_queue_number;

        // echo "success - queue Number = $actual_queNum. reservID= $queue_reservation_id";
          include_once "../config/core.php";
          $_SESSION['ticket_number'] = $prefix . $queue_number->last_queue_number;
          $_SESSION['reservation_id'] = $queue_reservation_id;
          $_SESSION['department'] = $department; // or actual department name if you have it
          $_SESSION['transaction'] = $_POST['transaction_id']; // or transaction name
          header("LOCATION:{$home_url}student/ticket.php");
    exit;
    } else {
        echo "failed";
    }
}


?>


<!-- Department Form -->
<div id="department-form" class="flex justify-center items-center mt-16">
  <div class="bg-[#ebf0f2] rounded-lg w-[1000px] p-8 space-y-6 shadow-lg">
    <p class="text-base text-[#071c42] text-center">
      <strong>Disclaimer:</strong> By using the ICC Online Queue Registration, you agree to provide accurate information.Your queue numbers are for personal use only. Missed or skipped turns may require rebooking. All personal data is handled in compliance with the Data Privacy Act of 2012.
    </p>

    <form aria-label="Queue registration form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?did={$did}"); ?>" method="POST">
      <div class="grid grid-cols-2 gap-6">
        
        <!-- Left Column -->
        <div class="space-y-4">
          <div input readonly class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-700 bg-gray-100 cursor-not-allowed">
            <?php echo $page_title; ?>
          </div>

          <input type="text" name="full_name" placeholder="Full Name" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
        </div>

        <!-- Right Column -->
        <div class="space-y-4">
          <?php
          $stmt = $transaction->read($did);
          echo "<select class='w-full px py-[15px] border border-gray-300 rounded-md' aria-label='Transaction type' name='transaction_id' required>";
          echo "<option value='' hidden>Transaction Type</option>";
          while ($row_transaction = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row_transaction);
            echo "<option value={$id}{$name}>{$name}</option>";
          }
          echo "</select>";
          ?>

          <!-- Empty select (likely redundant) -->
          <select class='w-full px py-[15px] border border-gray-300 rounded-md' aria-label='Transaction type' name='user_type' required>
          <option value="">Select User Category</option>
          <option value="">New Student</option>
          <option value="">Old Student</option>
          <option value="">Parent</option>
          </select>
        </div>

      </div>

      <!-- Submit Button -->
      <div class="flex justify-center items-center pt-4">
        <button type="submit" class="bg-[#071c42] text-white px-[120px] py-3 rounded-lg text-sm font-semibold hover:bg-[#00284a] transition duration-300">
          Print
        </button>
      </div>
    </form>
  </div>
</div>

<?php include_once "layout_foot.php"; ?>

