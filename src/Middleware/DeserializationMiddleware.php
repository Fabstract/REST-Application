<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\Serializer\Normalizer\Type;
use Fabstract\Component\REST\Assert;

class NormalizationMiddleware extends MiddlewareBase
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
        if (isset($this->serializer)) {
            $normalized = $this->serializer->getNormalizer()->denormalize(
                $this->request->getBody(),
                $this->type
            );

            $this->request->setBody($normalized);
        }
    }
}
