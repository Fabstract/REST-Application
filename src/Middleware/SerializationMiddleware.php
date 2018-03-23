<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\Constant\HttpMethods;
use Fabstract\Component\Http\Exception\StatusCodeException\BadRequestException;
use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\Serializer\Exception\ParseException;

class SerializationMiddleware extends MiddlewareBase
{

    public function before()
    {
        if ($this->requestCannotContainBody() === false &&
            isset($this->serializer)
        ) {
            try {
                $decoded = $this->serializer->getEncoder()->decode($this->request->getContent());
                $this->request->setBody($decoded);
            } catch (ParseException $exception) {
                throw new BadRequestException();
            }
        }
    }

    private function requestCannotContainBody()
    {
        return $this->request->getMethod() === HttpMethods::GET ||
            $this->request->getMethod() === HttpMethods::HEAD ||
            $this->request->getMethod() === HttpMethods::OPTIONS;
    }

    public function after()
    {
        if (isset($this->serializer)) {
            $serialized = $this->serializer->serialize($this->response->getReturnedValue());
            $this->response->setReturnedValue($serialized);
        }
    }
}
