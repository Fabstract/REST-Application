<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\REST\Constant\Services;

class SerializationMiddleware extends MiddlewareBase
{
    public function after()
    {
        if ($this->getContainer()->has(Services::SERIALIZER)) {
            $serialized = $this->serializer->serialize($this->response->getReturnedValue());
            $this->response->setReturnedValue($serialized);
        }
    }
}
