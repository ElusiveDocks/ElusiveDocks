<?php

require_once(
    __DIR__
    . DIRECTORY_SEPARATOR
    . '..'
    . DIRECTORY_SEPARATOR
    . 'Vendor'
    . DIRECTORY_SEPARATOR
    . 'autoload.php'
);

$httpKernel = new \ElusiveDocks\Core\Kernel\HttpKernel();
$httpRequest = new \ElusiveDocks\Core\Kernel\Http\Request();

$httpResponse = $httpKernel->handle(
    $httpRequest->capture()
);

$httpResponse->send();
