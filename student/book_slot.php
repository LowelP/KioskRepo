<?php
include_once "../config/database.php";
include_once "../objects/transaction.php";

$database = new Database();
$db = $database->getConnection();

$transaction = new Transaction ($db);

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
?>


    <!-- Department Form -->
    <div id="department-form" class="flex justify-center items-center mt-16">
      <div class="bg-[#ebf0f2] rounded-lg w-[1000px] p-8 space-y-6 shadow-lg">
        <p class="text-base text-[#071c42] text-center">
          <strong>Disclaimer:</strong> By using the ICC Online Queue Registration, you agree to provide accurate information...
        </p>
        <form aria-label="Queue registration form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?did={$did}"); ?>" method="POST">
        <div class="grid grid-cols-2 gap-6">
          <div class="space-y-4">
            <div readonly class="w-full px-4 py-3 border border-gray-300 rounded-md text-gray-700 bg-gray-100 cursor-not-allowed"><?php echo $page_title; ?></div>
            <input type="text" placeholder="Full Name" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          </div>
          <div class="space-y-4">

          <?php
                $stmt = $transaction->read($did);
                echo "<select class ='w-full px py-[15px] border border-gray-300 rounded-md' aria-label='Transaction type' name='transaction_id' required>";
                echo "<option value=''hidden>Transaction Type</option>";
                while ($row_transaction = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row_transaction);
                echo "<option value={$id}>{$name}</option>";
                }
                echo "</select>";

          ?>

            <input type="text" placeholder="Student ID / LRN" class="w-full px-4 py-3 border border-gray-300 rounded-md" />
          </div>
        </div>
        <div class="flex justify-center items-center pt-4">
          <button onclick="submitForm()" class="bg-[#071c42] text-white px-[120px] py-3 rounded-lg text-sm font-semibold hover:bg-[#00284a] transition duration-300">
            Submit
          </button>
        </div>
      </div>
    </div>
            </form>


