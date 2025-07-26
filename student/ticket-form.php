<?php

$page_title = "Ticket";
include_once "layout_head.php"; 

?>
        
<!-- <header class="w-full bg-[#07214A] px-6 py-4 shadow-md border-b-4 border-[#F0BB3F]">
    <div class="flex items-center space-x-4">
        <img src="images/Logo.svg" alt="Logo" class="w-12 h-12 object-contain" />
        <h1 class="text-white text-xl sm:text-2xl font-bold">Immaculada Conception College</h1>
    </div>
</header> -->
<div class="flex justify-center items-center min-h-[calc(100vh-100px)] px-4 py-10">
    <div class="bg-white rounded-lg shadow-xl p-8 max-w-xl w-full text-center space-y-6 border border-gray-300">
    <img src="images/Logo.svg" alt="Logo" class="w-20 h-20 mx-auto">
    <h2 class="text-xl font-bold text-[#07214A]">Immaculada Conception College of Soldier Hills Inc.</h2>
    <p class="text-lg text-gray-700">Your ticket number is</p>
    <div class="text-5xl font-extrabold text-[#F0BB3F]">${ticketNumber}</div>
    <div class="text-md font-semibold text-gray-800">Department: <span class="text-[#07214A]">${department}</span></div>
    <div class="text-md font-semibold text-gray-800">Transaction Type: <span class="text-[#07214A]">${transaction}</span></div>
        <p class="text-gray-600">There are <strong>${queueBefore}</strong> queuing before you</p>
        <div class="pt-4 border-t border-gray-300">
        <div class="font-bold text-[#07214A]">QUEUE# GENERATED</div>
        <div class="text-sm text-gray-500">${formattedDateTime}</div>
        </div>
    </div>
</div>