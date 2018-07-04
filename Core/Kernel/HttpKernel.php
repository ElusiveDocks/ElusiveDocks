<?php

namespace ElusiveDocks\Core\Kernel;

use ElusiveDocks\Core\Contract\Kernel\KernelInterface;
use ElusiveDocks\Core\Contract\Kernel\RequestInterface;
use ElusiveDocks\Core\Contract\Kernel\ResponseInterface;
use ElusiveDocks\Core\Kernel\Http\Response;
use ElusiveDocks\Core\ThreadManager;
use ElusiveDocks\Core\ThreadPool;

/**
 * Class HttpKernel
 * @package ElusiveDocks\Core\Kernel
 */
class HttpKernel implements KernelInterface
{

    /**
     * @inheritdoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $response = new Response();

        dump($Start = microtime(true));

/*
        for($run1 = 0; $run1 < 10; $run1++) {
            $Work = 0;
            $Manager[$run1] = new ThreadManager();
            $Pool[$run1] = new ThreadPool($Manager[$run1]);
            for ($run = 0; $run < 20; $run++) {
                $Work += $Wait = rand(0, 1);
                $Pool[$run1]->createThread('http://' . $_SERVER['SERVER_ADDR'] . '/thread.php?q=' . $Wait . '&c='.$run1.'.' . $run);
            }
        }
        dump(microtime(true) - $Start);


        foreach( $Manager as $threadManager ) {
            $threadManager->runThreads();
        }

        dump(microtime(true) - $Start);
        foreach( $Manager as $threadManager ) {
            foreach($threadManager->getThreadHandlers() as $threadHandler) {
                $Result = $threadHandler->getResult();
                if( !empty($Result) ) {
                    dump($threadHandler->getResult());
                }
            }
            $threadManager->viewStatistics();
        }

        dump(microtime(true) - $Start);
*/

        $TP = new ThreadPool(
            $TM = new ThreadManager()
        );

        dump(microtime(true) - $Start);

        for( $c = 0; $c < 256; $c++ ) {
            $TP->createThread('http://' . $_SERVER['SERVER_ADDR'] . '/thread.php?q=1&c='.$c);
        }

        dump(microtime(true) - $Start);

        $TM->runThreads();

        dump(microtime(true) - $Start);

        $TM->viewStatistics();

        dump(microtime(true) - $Start);

        return $response;
    }
}
