
<?php

include_once "layout_head.php";

?>
<!-- Dashboard Title -->
<section id="dashboard-title" class="px-4 md:px-10 pt-10 mt-[-10px]"></section>

  <!-- Department Buttons -->
  <div id="department-buttons" class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-4 sm:px-6 md:px-10 mt-10">
    <div class="flex flex-col gap-4">
      <a href="book_slot.php?did=4"><button class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">REGISTRAR</button></a>
      <a href="book_slot.php?did=1"><button class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">CASHIER</button></a>
    </div>
    <div class="flex flex-col gap-4">
      <a href="book_slot.php?did=2"><button  class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">ADMISSION</button></a>
      <a href="book_slot.php?did=3"><button class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">MIS</button></a>
    </div>  
</div>
    <!-- form will be here -->
  <?php include_once "kiosk-form.php"; ?>
</main>

<?php include_once "kiosk-alert.php"; ?>

<!-- Feedback Modal -->
<!-- modal feed back will be here -->
<?php

include_once "feedback-form.php"; 
include_once "layout_foot.php";
?>



