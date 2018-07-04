<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'bootstrap.php');

(new \ElusiveDocks\Dock\DebugDock())->run(
    new \ElusiveDocks\Dock\Carrier\DebugCarrier(
        new \Symfony\Component\VarDumper\Dumper\HtmlDumper()
    )
);

set_time_limit(300);

if( isset($_REQUEST['q']) ) {

    $Waste = 0.0;
    while($Waste < $_REQUEST['q']) {
        $Waste+=0.000001;
    }
//
//    $path = realpath(__DIR__).DIRECTORY_SEPARATOR.'log.txt';
//
//    $file = fopen($path,"a");
//    while (!flock($file,LOCK_EX))
//    {
        sleep($_REQUEST['q']);
//    }
//    fputs($file,json_encode($_REQUEST)."\n");
//    flock($file,LOCK_UN);
//    fclose($file);
}
