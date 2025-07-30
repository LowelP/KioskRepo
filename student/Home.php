
<?php
include_once "../config/core.php";  
include_once "../config/database.php";
include_once "../objects/queue_config.php";

$database = new Database();
$db = $database->getConnection();

$queue_config = new Queueconfig($db);


$page_title = "Deparments";
include_once "layout_head.php";


if (isset($_POST['department'])) {

  $department = $_POST['department'];



  if ($department == "registrar") {
    $did = 4;
    $available_slot = $queue_config->getBookslot($did);
    if ($available_slot >= 0) {
      header("LOCATION:{$home_url}student/book_slot.php?did=4");
    }else{
      include_once "booking_alert.php";
      $show_modal = true;
    }

  }

  if ($department == "mis") {
    $did = 3;
    $available_slot = $queue_config->getBookslot($did);
    
    $available_slot = $queue_config->getBookslot($did);
    if ($available_slot >= 0) {
      header("LOCATION:{$home_url}student/book_slot.php?did=3");
    }else{
      include_once "booking_alert.php";
      $show_modal = true;
    }
  }

  if ($department == "cashier") {
    $did = 1;
    $available_slot = $queue_config->getBookslot($did);
    
    include_once "booking_alert.php";
    if ($available_slot >= 0) {
      header("LOCATION:{$home_url}student/book_slot.php?did=1");
    }else{
      include_once "booking_alert.php";
      $show_modal = true;
    }
  }

  if ($department == "admission") {
    $did = 2;
    $available_slot = $queue_config->getBookslot($did);
    if ($available_slot >= 0) {
      header("LOCATION:{$home_url}student/book_slot.php?did=2");
    }else{
      include_once "booking_alert.php";
      $show_modal = true; 
    }
  }
}

?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post'>
    <!-- Dashboard Title -->
    <section id="dashboard-title" class="px-4 md:px-10 pt-10 mt-[-10px]"></section>

      <!-- Department Buttons -->
      <div id="department-buttons" class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-4 sm:px-6 md:px-10 mt-10">
        <div class="flex flex-col gap-4">
          <button type="submit" name="department" value="registrar" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">REGISTRAR</button>
          <button type="submit" name="department" value="cashier" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">CASHIER</button>
        </div>
        <div class="flex flex-col gap-4">
          <button type="submit" name="department" value="admission"  class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">ADMISSION</button>
          <button type="submit" name="department" value="mis" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">MIS</button>
        </div>  
    </div>
  </main>
</form>


<!-- Feedback Modal -->
<!-- modal feed back will be here -->
<?php


include_once "feedback-form.php"; 
include_once "layout_foot.php";
?>



