<?php
include_once "../config/core.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Printout</title>
    <script src="../libs/js/tray-2.2.5/js/qz-tray.js"></script> <!-- Adjust path if needed -->
</head>
<body>

<?php
    // Sample hardcoded data – replace with real session values if needed
    $ticketNumber = $_SESSION['ticket_number'];
    $department = "Registrar";
    $transaction = "Enrollment";
    $queueBefore = 5;

    echo "<script>\n";
    echo "window.ticketNumber = '{$ticketNumber}';\n";
    echo "window.department = '{$department}';\n";
    echo "window.transaction = '{$transaction}';\n";
    echo "window.queueBefore = '{$queueBefore}';\n";
    echo "</script>\n";
?>

<script>
    // ESC/POS command definitions
    const ESC = String.fromCharCode(27);
    const GS = String.fromCharCode(29);

    // Text formatting
    const initPrinter      = ESC + '@';
    const alignCenter      = ESC + 'a' + String.fromCharCode(1);
    const alignLeft        = ESC + 'a' + String.fromCharCode(0);
    const boldOn           = ESC + 'E' + String.fromCharCode(1);
    const boldOff          = ESC + 'E' + String.fromCharCode(0);
    const doubleHeightOn   = ESC + '!' + String.fromCharCode(16);
    const doubleHeightOff  = ESC + '!' + String.fromCharCode(0);
    const feedLines        = ESC + 'd' + String.fromCharCode(3);
    const cutPaper         = GS + 'V' + String.fromCharCode(66) + String.fromCharCode(0);

    // Build ticket
    const ticketText = 
        initPrinter +
        alignCenter +
        "IMMACULADA CONCEPTION COLLEGE\n" +
        "   Soldier Hills Inc.\n\n" +
        "-------------------------------\n" +
        alignLeft +
        "       TICKET #:\n" +
        boldOn + doubleHeightOn +
        "         " + window.ticketNumber + "\n" +
        boldOff + doubleHeightOff + "\n" +
        " Department: " + window.department + "\n" +
        "Transaction: " + window.transaction + "\n" +
        "   Waiting: " + window.queueBefore + " others\n" +
        "-------------------------------\n" +
        alignCenter +
        "Thank you for waiting!\n" +
        feedLines +
        cutPaper;

    // Print immediately
    function printTicket() {
        const printerName = "POS-58(copy of 3)"; // Your actual printer name

        qz.websocket.connect().then(() => {
            return qz.printers.find(printerName);
        }).then(printer => {
            const config = qz.configs.create(printer, { encoding: 'UTF-8' });
            return qz.print(config, [{
                type: 'raw',
                format: 'plain',
                data: ticketText
            }]);
        }).catch(err => {
            console.error("Print error:", err);
        });
    }

    window.onload = printTicket;
</script>

</body>
</html>
