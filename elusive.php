#!/usr/bin/env php
<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'bootstrap.php');

(new \ElusiveDocks\Dock\DebugDock())->run(
    new \ElusiveDocks\Dock\Carrier\DebugCarrier(
        new \Symfony\Component\VarDumper\Dumper\CliDumper()
    )
);

$cliKernel = new \ElusiveDocks\Core\Kernel\CliKernel();
$cliRequest = new \ElusiveDocks\Core\Kernel\Cli\Request();

$cliResponse = $cliKernel->handle(
    $cliRequest->capture()
);

$cliResponse->send();
