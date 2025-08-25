<?php
include_once "../config/core.php"; // for session + $home_url

// Capture the data passed from bookslot.php
$did             = $_GET['did'] ?? '';
$full_name       = $_POST['full_name'] ?? '';
$transaction_id  = $_POST['transaction_id'] ?? '';
$transaction_name= $_POST['transaction_name'] ?? '';
$user_type       = $_POST['user_type'] ?? '';
$priority        = isset($_POST['priority']) ? 'Yes' : 'No';

// Map department name (same as in bookslot.php)
switch ($did) {
    case 1: $department = "Cashier";   break;
    case 2: $department = "Admission"; break;
    case 3: $department = "MIS";       break;
    case 4: $department = "Registrar"; break;
    default:$department = "Unknown";   break;
}

// Build query string for cancel/edit link
$query = http_build_query([
    'did'              => $did,
    'full_name'        => $full_name,
    'transaction_id'   => $transaction_id,
    'transaction_name' => $transaction_name,
    'user_type'        => $user_type,
    'priority'         => $priority === 'Yes' ? '1' : ''
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Confirm Your Details</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-6 space-y-4">
    <div class="text-center">
      <img src="images/Logo.svg" alt="Logo" class="mx-auto h-12 mb-2">
      <h2 class="text-lg font-semibold">Immaculada Concepcion College</h2>
      <p class="text-sm text-gray-500">Please confirm your details</p>
    </div>

    <div class="space-y-2 text-sm">
      <p><strong>Department:</strong> <?= htmlspecialchars($department) ?></p>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($full_name) ?></p>
      <p><strong>Transaction:</strong> <?= htmlspecialchars($transaction_name) ?></p>
      <p><strong>User Category:</strong> <?= htmlspecialchars($user_type) ?></p>
      <p><strong>Priority:</strong> <?= htmlspecialchars($priority) ?></p>
    </div>

    <form method="POST" action="bookslot.php?did=<?= htmlspecialchars($did) ?>" class="flex justify-between">
      <!-- Pass the values forward -->
      <input type="hidden" name="full_name" value="<?= htmlspecialchars($full_name) ?>">
      <input type="hidden" name="transaction_id" value="<?= htmlspecialchars($transaction_id) ?>">
      <input type="hidden" name="transaction_name" value="<?= htmlspecialchars($transaction_name) ?>">
      <input type="hidden" name="user_type" value="<?= htmlspecialchars($user_type) ?>">
      <input type="hidden" name="priority" value="<?= $priority === 'Yes' ? '1' : '' ?>">

      <button type="submit" 
              class="bg-blue-900 text-white px-4 py-2 rounded hover:bg-blue-800">
        Confirm & Print
      </button>
    </form>

    <div class="text-center">
      <a href="bookslot.php?<?= $query ?>" 
         class="text-red-600 hover:underline text-sm">
        Cancel / Edit
      </a>
    </div>
  </div>
</body>
</html>
