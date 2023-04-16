
<?php
//  Credits:
//  https://gist.github.com/alexmchale/acfd581995ff44a8a24b82938019a04e

$fpath = '';

$message  = time() . "\n";
$message .= "------------------------------------------------------------------------\n";
$message .= "\n";
$message .= json_encode($_REQUEST, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n";
$message .= "\n";
$message .= json_encode($_SERVER, JSON_PRETTY_PRINT | JSON_FORCE_OBJECT) . "\n";
$message .= "\n";

$filename = "logger.txt";

file_put_contents($fpath . "logger.txt", $message, FILE_APPEND);

echo "OK\n";
