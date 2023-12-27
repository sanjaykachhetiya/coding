<?php

$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

echo '<pre>';
//echo ' Start SERVER';
//print_r($_SERVER);
echo '</pre>';

// Script start
$rustart = getrusage();

// Code ...

// Script end
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}

$time_log = '';

$ru = getrusage();
$time_log .= "This process used " . rutime($ru, $rustart, "utime") . " ms for its computations\n";
$time_log .= "It spent " . rutime($ru, $rustart, "stime") .
    " ms in system calls\n";
	
	
	// Starting clock time in seconds 
$start_time = microtime(true); 
$a=1; 
  
// Start loop 
for($i = 1; $i <=1000; $i++) 
{ 
    $a++; 
}  
  
// End clock time in seconds 
$end_time = microtime(true); 
  
// Calculate script execution time 
$execution_time = ($end_time - $start_time); 
  
echo " Execution time of script = ".$execution_time." sec"; 

print_r( debug_print_backtrace() );
var_dump(debug_backtrace());

//Something to write to txt log
$log  = "REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "REQUEST_URI: ".($_SERVER['REQUEST_URI']!=''?'Success':'Failed').PHP_EOL.
        "Path: ".$_SERVER['DOCUMENT_ROOT'].PHP_EOL.
        "Memory Usage : ".formatBytes(memory_get_peak_usage()).PHP_EOL.
        "memory_get_usage  : ".memory_get_usage().PHP_EOL.
        "Execution Time : ".$time_log.PHP_EOL.
        "Execution Time Normal : ".$execution_time.PHP_EOL.
        "Actual Link : ".$actual_link.PHP_EOL.
        "debug_print_backtrace : ".debug_print_backtrace().PHP_EOL.
        "-------------------------".PHP_EOL;
//Save string to log, use FILE_APPEND to append.
file_put_contents('./log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
 
echo 'Hello <br><hr><br>';

function formatBytes($bytes, $precision = 2) {
    $units = array("b", "kb", "mb", "gb", "tb");

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . " " . $units[$pow];
}

print formatBytes(memory_get_peak_usage());


// another way to call error_log():
error_log("You messed up!", 3, "test.log");

?>