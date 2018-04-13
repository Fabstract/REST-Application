<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\REST\Exception\AssertionException;

class Assert extends \Fabstract\Component\Assert\Assert
{
    /**
     * @param string $name
     * @param string $expected
     * @param string $given
     * @return AssertionException
     */
    protected static function generateException($name, $expected, $given)
    {
        $exception = parent::generateException($name, $expected, $given);
        return new AssertionException(
            $exception->getMessage(),
            $exception->getCode(),
            $exception
        );
    }
}
