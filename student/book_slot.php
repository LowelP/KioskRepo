<?php
include_once "../config/database.php";
include_once "../objects/transaction.php";
include_once "../objects/queue_reservation.php";
include_once "../objects/department.php";
include_once "../objects/queue_number.php";

$database = new Database();
$db = $database->getConnection();

$transaction       = new Transaction($db);
$queue_reservation = new QueueReservation($db);
$departments       = new Department($db);
$queue_number      = new QueueNumber($db);

$did = isset($_GET['did']) ? $_GET['did'] : die("ERROR: 404 Not Found");

$department = null;
if     ($did == 1) { $department = "Cashier";   }
else if($did == 2) { $department = "Admission"; }
else if($did == 3) { $department = "MIS";       }
else if($did == 4) { $department = "Registrar"; }
else               { $department = "Department Not Available"; }

$page_title = $department;
include_once "layout_head.php";

if ($_POST) {
    // Generate prefix based on department
    switch ($did) {
        case 1:  $prefix = "C"; break;
        case 2:  $prefix = "A"; break;
        case 3:  $prefix = "M"; break;
        case 4:  $prefix = "R"; break;
        default: $prefix = "X"; break;
    }

    // Generate queue reservation ID
    $queue_reservation_id = $prefix . rand(1000, 9999);

    // --- NEW: capture both id and name (name is used for the ticket) ---
    $posted_tx_id   = isset($_POST['transaction_id'])   ? trim((string)$_POST['transaction_id'])   : '';
    $posted_tx_name = isset($_POST['transaction_name']) ? trim((string)$_POST['transaction_name']) : '';

    // Fallback: if name is empty (e.g., JS didn’t run), try DB lookup by id
    if ($posted_tx_name === '' && $posted_tx_id !== '') {
        try {
            // Use the same table your Transaction object reads from.
            // If your table is named differently, adjust "transactions" below.
            $stmt = $db->prepare("SELECT name FROM transactions WHERE id = :id LIMIT 1");
            $stmt->execute([":id" => $posted_tx_id]);
            $posted_tx_name = (string)$stmt->fetchColumn();
        } catch (Throwable $e) {
            // Silently ignore; will just print empty if not found
            $posted_tx_name = '';
        }
    }

    // Fill in reservation fields
    $queue_reservation->full_name            = $_POST['full_name'] ?? '';
    $queue_reservation->department_id        = $did;
    $queue_reservation->queue_reservation_id = $queue_reservation_id;
    $queue_reservation->transaction_id       = $posted_tx_id;  // keep id for DB logic
    $queue_reservation->user_type            = $_POST['user_type'] ?? '';
    $queue_reservation->source               = "By Kiosk";

    $queue_number->queue_reservation_id = $queue_reservation_id;

    // Save reservation
    if ($queue_reservation->create()) {
        // Update queue number
        $queue_number->UpdateQueueNumber($did);

        // Deduct slot
        $departments->deductSlot($did);

        // Get new queue number
        $actual_queNum = $queue_number->last_queue_number;

        // Prepare session for ticket
        include_once "../config/core.php"; // ensures session + $home_url

        $_SESSION['ticket_number']  = $prefix . $queue_number->last_queue_number;
        $_SESSION['reservation_id'] = $queue_reservation_id;
        $_SESSION['department']     = $department;             // printed on ticket
        $_SESSION['transaction']    = $posted_tx_name;         // <-- HUMAN NAME printed on ticket
        $_SESSION['transaction_id'] = $posted_tx_id;           // keep id if you need it later

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
      <strong>Disclaimer:</strong>Disclaimer: By using this kiosk, you agree to provide accurate information. Your queue numbers are for personal use only. Missed or skipped turns may require rebooking. All personal data is handled in compliance with the Data Privacy Act of 2012.
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

          <!-- Transaction Type (same design; keeps chevron; keeps padding) -->
          <?php $stmt = $transaction->read($did); ?>
          <div class="space-y-2">
            <div class="relative">
              <select
                name="transaction_id"
                aria-label="Transaction Type"
                required
                class="h-12 w-full rounded-md border border-gray-300 bg-white px-4 pr-14 text-slate-800
                       appearance-none focus:outline-none focus:ring-2 focus:ring-[#07214A] focus:border-[#07214A]/30"
                id="transaction_id"
              >
                <option value="" disabled selected hidden>Transaction Type</option>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                  <?php
                    $id   = $row['id']   ?? '';
                    $name = $row['name'] ?? '';
                  ?>
                  <option
                    value="<?= htmlspecialchars($id, ENT_QUOTES) ?>"
                    data-name="<?= htmlspecialchars($name, ENT_QUOTES) ?>"
                  >
                    <?= htmlspecialchars($name) ?>
                  </option>
                <?php endwhile; ?>
              </select>

              <!-- Chevron (kept, slightly inside) -->
              <svg class="pointer-events-none absolute right-6 md:right-8 top-1/2 -translate-y-1/2 h-5 w-5 text-[#07214A]"
                   viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M6 8l4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>

              <!-- Hidden field to carry the human-readable name for the ticket -->
              <input type="hidden" name="transaction_name" id="transaction_name">
            </div>
          </div>

          <script>
          // Keep hidden transaction_name in sync with the selected option's text
          (function () {
            const sel = document.getElementById('transaction_id');
            const hid = document.getElementById('transaction_name');

            function syncName() {
              const opt = sel.options[sel.selectedIndex];
              hid.value = opt ? (opt.getAttribute('data-name') || opt.textContent.trim()) : '';
            }
            sel.addEventListener('change', syncName);
            // Initialize on load (in case of default selection)
            syncName();
          })();
          </script>

          <!-- User Category (kept exactly) -->
          <div class="space-y-2">
            <div class="relative">
              <select name="user_type" required
                class="h-12 w-full rounded-md border border-gray-300 bg-white px-4 pr-14 text-slate-800
                       appearance-none focus:outline-none focus:ring-2 focus:ring-[#07214A] focus:border-[#07214A]/30">
                <option value="" disabled selected hidden>Select User Category</option>
                <option value="new">New Student</option>
                <option value="old">Old Student</option>
                <option value="parent">Parent</option>
              </select>

              <svg class="pointer-events-none absolute right-6 md:right-8 top-1/2 -translate-y-1/2 h-5 w-5 text-[#07214A]"
                   viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path d="M6 8l4 4 4-4" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
          </div>

          <label class="inline-flex items-center text-sm text-slate-600 select-none ml-4 md:ml-6">
            <input type="checkbox" name="priority" value="1"
                   class="h-4 w-4 rounded border-gray-300 text-[#071c42] focus:ring-[#071c42]">
            <span class="ml-2">Priority (Pregnant, PWD, or Senior Citizen)</span>
          </label>
        </div>

        <!-- Centered button slightly narrower than a column -->
        <div class="md:col-span-2 flex justify-center">
          <button type="submit"
            class="bg-[#071c42] text-white font-bold py-2 px-6 rounded-md w-full md:w-[45%]">
            Print
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

<?php include_once "layout_foot.php"; ?>
