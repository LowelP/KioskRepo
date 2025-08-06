<?php
// Hardcoded values
$ticketNumber = "A001";
$department = "REGISTRAR";
$transaction = "ENROLLMENT";
$queueBefore = 3;
$formattedDate = "JULY 30, 2025";
$formattedTime = "2:15 PM";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Ticket Print</title>
  <style>
    body {
      font-family: monospace;
      font-size: 12px;
      margin: 0;
      padding: 10px;
      width: 58mm;
    }
    .center { text-align: center; }
    .bold { font-weight: bold; }
    pre {
      white-space: pre-wrap;
      word-wrap: break-word;
    }
  </style>
</head>
<body onload="window.print()">
<pre class="bold center">
IMMACULADA CONCEPTION
COLLEGE OF SOLDIER HILLS
------------------------------
</pre>

<pre>
TICKET NO : <?php echo $ticketNumber; ?>
DEPARTMENT: <?php echo $department; ?>
TRANSACTION: <?php echo $transaction; ?>
QUEUED BEFORE YOU: <?php echo $queueBefore; ?>
------------------------------
GENERATED: <?php echo $formattedDate; ?>

             <?php echo $formattedTime; ?>
</pre>

<pre class="center bold">
==============================
THANK YOU FOR WAITING!
==============================
</pre>
</body>
</html>
