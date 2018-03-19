<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\REST\Exception\AssertionException;

class Assert extends \Fabs\Component\Assert\Assert
{
    protected static function generateException($name, $expected, $given)
    {
        $exception = parent::generateException($name, $expected, $given);
        throw new AssertionException(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}
