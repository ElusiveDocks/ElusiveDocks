<?php
ini_set('display_errors', 1);
ob_end_flush();
flush();

//phpinfo();exit();

$autoLoader = realpath(
    __DIR__
    . DIRECTORY_SEPARATOR
    . '..'
    . DIRECTORY_SEPARATOR
    . 'vendor'
    . DIRECTORY_SEPARATOR
    . 'autoload.php'
);

require_once($autoLoader);

$httpKernel = new \ElusiveDocks\Core\Kernel\HttpKernel();
$httpRequest = new \ElusiveDocks\Core\Kernel\Http\Request();

$httpResponse = $httpKernel->handle(
    $httpRequest->capture()
);

$httpResponse->send();
