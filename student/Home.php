
<?php

include_once "layout_head.php";

?>
  <main class="flex-1 flex flex-col overflow-auto">
    <!-- Header -->
    <header class="w-full bg-[#07214A] px-6 py-4 shadow-md border-b-4 border-[#F0BB3F]">
      <div class="flex items-center space-x-4">
        <img src="images/Logo.svg" alt="Logo" class="w-12 h-12 object-contain" />
        <h1 class="text-white text-xl sm:text-2xl font-bold">
          Immaculada Conception College
        </h1>
      </div>
    </header>

    <!-- Dashboard Title -->
    <section id="dashboard-title" class="px-4 md:px-10 pt-10 mt-[-10px]"></section>

    <!-- Department Buttons -->
    <div id="department-buttons" class="grid grid-cols-1 sm:grid-cols-2 gap-6 px-4 sm:px-6 md:px-10 mt-10">
      <div class="flex flex-col gap-4">
        <button onclick="showForm('Registrar')" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">REGISTRAR</button>
        <button onclick="showForm('Cashier')" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">CASHIER</button>
      </div>
      <div class="flex flex-col gap-4">
        <button onclick="showForm('Admission')" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">ADMISSION</button>
        <button onclick="showForm('MIS')" class="bg-[#071c42] text-white py-10 px-6 rounded-lg text-lg font-semibold w-full">MIS</button>
      </div>
    </div>

    <!-- form will be here -->
     <?php include_once "kiosk-form.php"; ?>
  </main>



    <!-- Feedback Modal -->
    <!-- modal feed back will be here -->
<?php 
include_once "feedback-form.php"; 
include_once "layout_foot.php";
?>



