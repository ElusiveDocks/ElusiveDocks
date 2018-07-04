<?php
/**
 * Prepare ElusiveDocks entry point
 */

ini_set('display_errors', 1);
ob_end_flush();
flush();

require_once(
    __DIR__.DIRECTORY_SEPARATOR
    .'Vendor'.DIRECTORY_SEPARATOR.'autoload.php'
);
