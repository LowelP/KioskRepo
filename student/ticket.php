<?php
// ==================== CONFIG ====================
$PRINTER_BACKEND = 'windows';              // 'windows' | 'cups' | 'tcp' | 'debug'
$WINDOWS_SHARE = '\\\\Joseph\\POS-58(copy of 3)';



$PRINTER_NAME    = 'POS-58(copy of 3)';                // for 'cups'
$PRINTER_HOST    = '192.168.1.200';        // for 'tcp'
$PRINTER_PORT    = 9100;                   // for 'tcp'
$DEBUG_PATH      = __DIR__ . '/ticket_debug.bin'; // for 'debug'

// -------------------- session data --------------------
session_start();
$ticketNumber = $_SESSION['ticket_number'] ?? 'TICKET';
$department   = $_SESSION['department']     ?? '';
$transaction  = $_SESSION['transaction']    ?? '';
$queueBefore  = isset($_SESSION['queue_before']) ? (int)$_SESSION['queue_before'] : 5;

// ==================== ESC/POS HELPERS ====================
function esc($n){ return chr(27) . $n; }
function gs($n){  return chr(29) . $n; }
// Character size (GS ! n): width/height 1..8
function charSize($w,$h){ $w=max(1,min(8,(int)$w)); $h=max(1,min(8,(int)$h)); return gs('!').chr((($h-1)<<4)|($w-1)); }
function sizeReset(){ return gs('!') . chr(0); }

function buildTicket($ticketNumber,$department,$transaction,$queueBefore){
    $init=esc('@'); $alignCenter=esc('a').chr(1); $alignLeft=esc('a').chr(0);
    $boldOn=esc('E').chr(1); $boldOff=esc('E').chr(0); $feed3=esc('d').chr(3);
    $cutFull=gs('V').chr(66).chr(0); $doubleHeightOff=esc('!').chr(0);
    $timestamp = date('Y-m-d H:i:s');

    $out  = $init . $alignCenter;
    $out .= "IMMACULADA CONCEPCION COLLEGE\n";
    $out .= "   Soldier Hills Inc.\n\n";
    $out .= "-------------------------------\n";
    // BIG ticket #
    $out .= $boldOn . charSize(4,4) . ($ticketNumber ?: 'TICKET') . "\n";
    $out .= sizeReset() . $boldOff . $doubleHeightOff;
    // normal lines
    $out .= ($department ?: '') . "\n";
    $out .= ($transaction ?: '') . "\n";
    $out .= $alignLeft . "There are " . (int)$queueBefore . " queuing before you \n";
    $out .= "-------------------------------\n";
    $out .= $alignCenter . "queue # generated\n" . $timestamp . "\n";
    $out .= $feed3 . $cutFull;
    return $out;
}

// ==================== BACKENDS ====================
function print_via_windows_share($sharePath, $rawBytes){
    $tmp = tempnam(sys_get_temp_dir(), 'tkt_');
    file_put_contents($tmp, $rawBytes);

    // Add quotes around the UNC because it has spaces/parentheses
    $cmd = 'cmd /c copy /B ' . escapeshellarg($tmp) . ' "' . $sharePath . '"';
    $out = shell_exec($cmd);

    @unlink($tmp);

    if (stripos($out, '1 file(s) copied') !== false) {
        return 'sent';
    }
    return 'failed: ' . $out;
}



function print_via_cups($printerName, $rawBytes){
    $tmp = tempnam(sys_get_temp_dir(), 'tkt_');
    file_put_contents($tmp, $rawBytes);
    $cmd = sprintf('lp -d %s -o raw %s 2>&1', escapeshellarg($printerName), escapeshellarg($tmp));
    $out = shell_exec($cmd);
    @unlink($tmp);
    return $out ?: 'sent';
}
function print_via_tcp($host,$port,$rawBytes){
    $sock = @fsockopen($host,(int)$port,$errno,$errstr,5.0);
    if(!$sock) throw new Exception("TCP connect failed: $errstr ($errno)");
    stream_set_timeout($sock,5);
    $ok = fwrite($sock,$rawBytes);
    fclose($sock);
    if($ok === false) throw new Exception('TCP write failed');
    return 'sent';
}
function print_via_debug($path,$rawBytes){
    file_put_contents($path,$rawBytes);
    return "written to $path";
}

// ==================== CONTROLLER ====================
$raw = buildTicket($ticketNumber,$department,$transaction,$queueBefore);
$status = 'unknown'; $error = null;

try{
    switch($PRINTER_BACKEND){
        case 'windows': $status = print_via_windows_share($WINDOWS_SHARE, $raw); break;
        case 'cups':    $status = print_via_cups($PRINTER_NAME, $raw); break;
        case 'tcp':     $status = print_via_tcp($PRINTER_HOST, $PRINTER_PORT, $raw); break;
        case 'debug':   $status = print_via_debug($DEBUG_PATH, $raw); break;
        default:        throw new Exception('Invalid backend');
    }
}catch(Exception $e){ $error = $e->getMessage(); }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"><title>Ticket Printout</title>
<style>
body{font-family:system-ui,Segoe UI,Roboto,Arial,sans-serif;padding:24px;color:#0b1220}
.card{max-width:560px;margin:0 auto;border:1px solid #e5e7eb;border-radius:12px;padding:20px;box-shadow:0 6px 18px rgba(0,0,0,.06)}
h1{font-size:20px;margin:0 0 12px}.ok{color:#0a7a20}.err{color:#b91c1c}
.row{margin:6px 0}.btn{display:inline-block;margin-top:14px;padding:10px 14px;border-radius:8px;border:1px solid #111827;text-decoration:none;color:#111827}
.btn:hover{background:#111827;color:#fff}.muted{color:#6b7280}code{background:#f3f4f6;padding:2px 6px;border-radius:6px}
</style>
</head>
<body>
<div class="card">
  <h1>Ticket printing </h1>
  <?php if($error): ?>
    <div class="row err"><strong>Print error:</strong> <?php echo htmlspecialchars($error); ?></div>
  <?php else: ?>
    <div class="row ok"><strong>Print status:</strong> <?php echo htmlspecialchars($status); ?></div>
  <?php endif; ?>
  <div class="row"><span class="muted">Ticket #:</span> <code><?php echo htmlspecialchars($ticketNumber); ?></code></div>
  <div class="row"><span class="muted">Department:</span> <?php echo htmlspecialchars($department); ?></div>
  <div class="row"><span class="muted">Transaction:</span> <?php echo htmlspecialchars($transaction); ?></div>
  <div class="row"><span class="muted">Queue before:</span> <?php echo (int)$queueBefore; ?></div>
  <a class="btn" href="home.php">Back to Home</a>
  <a class="btn" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Reprint</a>
</div>
</body>
</html>
