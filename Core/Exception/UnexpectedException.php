<?php

namespace ElusiveDocks\Core\Exception;

/**
 * Class UnexpectedException
 * @package ElusiveDocks\Core\Exception
 */
class UnexpectedException extends AbstractException
{
    /**
     * @inheritDoc
     */
    public function __construct($message = null)
    {
        parent::__construct('Unexpected Exception' . ($message ? ': ' . $message : ''), -1);
    }

}
