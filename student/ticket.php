<?php 
include_once "../config/core.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Printout</title>
    <script src="../libs/js/tray-2.2.5/js/qz-tray.js"></script>

    <style>
        #printModal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; 
            top: 0;
            width: 100%; 
            height: 100%;
            background-color: rgba(0,0,0,.5);
        }
        #printModalContent {
            position: absolute; 
            top: 50%; 
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff; 
            padding: 30px 40px; 
            border-radius: 8px;
            text-align: center; 
            font-family: sans-serif; 
            font-size: 16px;
        }
        .spinner {
            margin-top: 15px;
            border: 4px solid #ccc; 
            border-top: 4px solid #3498db;
            border-radius: 50%; 
            width: 30px; 
            height: 30px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 
            0% {transform: rotate(0)} 
            100% {transform: rotate(360deg)} 
        }
    </style>
</head>
<body>

<?php
$ticketNumber = $_SESSION['ticket_number'] ?? '';
$department   = $_SESSION['department'] ?? '';
$transaction  = $_SESSION['transaction'] ?? '';
$queueBefore  = 5;

echo "<script>\n";
echo "window.ticketNumber = " . json_encode($ticketNumber) . ";\n";
echo "window.department   = " . json_encode($department) . ";\n";
echo "window.transaction  = " . json_encode($transaction) . ";\n";
echo "window.queueBefore  = " . json_encode($queueBefore) . ";\n";
echo "</script>\n";
?>

<div id="printModal">
    <div id="printModalContent">
        Printing ticket, please wait…
        <div class="spinner"></div>
    </div>
</div>

<script>
// -------- QZ certificate ----------
qz.security.setCertificatePromise(function(resolve, reject) {
    fetch("cert/qz-tray-public-key.pem")
        .then(res => { 
            if (!res.ok) throw new Error("Failed to load certificate"); 
            return res.text(); 
        })
        .then(resolve)
        .catch(err => { 
            console.error("Certificate error:", err); 
            reject(err); 
        });
});

// -------- ESC/POS constants ----------
const ESC = String.fromCharCode(27);
const GS  = String.fromCharCode(29);

const initPrinter     = ESC + '@';
const alignCenter     = ESC + 'a' + String.fromCharCode(1);
const alignLeft       = ESC + 'a' + String.fromCharCode(0);
const boldOn          = ESC + 'E' + String.fromCharCode(1);
const boldOff         = ESC + 'E' + String.fromCharCode(0);
const doubleHeightOff = ESC + '!' + String.fromCharCode(0);
const feedLines       = ESC + 'd' + String.fromCharCode(3);
const cutPaper        = GS  + 'V' + String.fromCharCode(66) + String.fromCharCode(0);

// Character size helpers (BIG ticket #, then reset)
function charSize(width, height) {
    const w = Math.max(1, Math.min(8, width));
    const h = Math.max(1, Math.min(8, height));
    return GS + '!' + String.fromCharCode(((h - 1) << 4) | (w - 1));
}
const sizeReset = GS + '!' + String.fromCharCode(0);

function buildTicketText() {
    const timestamp = new Date().toLocaleString();

    return (
        initPrinter +
        alignCenter +
        "IMMACULADA CONCEPCION COLLEGE\n" +
        "   Soldier Hills Inc.\n\n" +
        "-------------------------------\n" +

        // BIG TICKET #
        boldOn + charSize(4, 4) +
        (window.ticketNumber || "TICKET") + "\n" +
        sizeReset + boldOff + doubleHeightOff +

        (window.department || "") + "\n" +
        (window.transaction || "") + "\n" +

        alignLeft +
        "There are " + (window.queueBefore || 0) + " queuing before you \n" +
        "-------------------------------\n" +
        alignCenter +
        "queue # generated\n" +
        timestamp + "\n" +
        feedLines +
        cutPaper
    );
}

function showModal() { 
    document.getElementById('printModal').style.display = 'block'; 
}
function hideModal() { 
    document.getElementById('printModal').style.display = 'none'; 
}
function goHome() { 
    window.location.replace("home.php"); 
}

const PRINTER_NAME = "POS-58(copy of 3)"; // <--- set your printer name

async function printOnce() {
    const data = buildTicketText();
    const printer = await qz.printers.find(PRINTER_NAME);
    const cfg = qz.configs.create(printer, { encoding: "UTF-8" });
    await qz.print(cfg, [{ type: "raw", format: "plain", data }]);
}

async function startPrintFlow() {
    try {
        showModal();
        if (!qz.websocket.isActive()) { 
            await qz.websocket.connect(); 
        }

        // First print
        await printOnce();
    } catch (e) {
        console.error("Initial print error:", e);
        alert("Printing failed: " + (e?.message || e));
    } finally {
        hideModal();

        // Ask reprint
        const wantsReprint = confirm("Reprint the ticket?");
        if (wantsReprint) {
            (async () => {
                try {
                    showModal();
                    await printOnce();
                } catch (e) {
                    console.error("Reprint error:", e);
                    alert("Reprint failed: " + (e?.message || e));
                } finally {
                    hideModal();
                    alert("Returning to Home.");
                    goHome();
                }
            })();
        } else {
            alert("Returning to Home.");
            goHome();
        }
    }
}

window.onload = startPrintFlow;
</script>

</body>
</html>
