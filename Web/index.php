<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bootstrap.php');

(new \ElusiveDocks\Dock\DebugDock())->run(
    new \ElusiveDocks\Dock\Carrier\DebugCarrier(
        new \Symfony\Component\VarDumper\Dumper\HtmlDumper()
    )
);

$httpKernel = new \ElusiveDocks\Core\Kernel\HttpKernel();
$httpRequest = new \ElusiveDocks\Core\Kernel\Http\Request();

$httpResponse = $httpKernel->handle(
    $httpRequest->capture()
);

$httpResponse->send();
