<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\Exception\StatusCodeException\BadRequestException;
use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\REST\Constant\Services;
use Fabstract\Component\Serializer\Exception\ParseException;
use Fabstract\Component\Serializer\Normalizer\Type;
use Fabstract\Component\REST\Assert;

class DeserializationMiddleware extends MiddlewareBase
{
    /** @var Type */
    private $type = null;

    function __construct($type)
    {
        Assert::isType($type, Type::class, 'type');
        $this->type = $type;
    }

    public function before()
    {
        if ($this->getContainer()->has(Services::SERIALIZER) === true) {
            try {
                $decoded = $this->serializer->getEncoder()->decode($this->request->getContent());
            } catch (ParseException $exception) {
                throw new BadRequestException();
            }

            $normalized = $this->serializer->getNormalizer()->denormalize($decoded, $this->type);

            $this->request->setBody($normalized);
        }
    }
}
