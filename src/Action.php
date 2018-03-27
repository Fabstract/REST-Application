<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\Serializer\Normalizer\ArrayType;
use Fabstract\Component\Serializer\Normalizer\Type;
use Fabstract\Component\REST\Middleware\DeserializationMiddleware;
use Fabstract\Component\REST\Middleware\ValidationMiddleware;

class Action extends \Fabstract\Component\Http\Action
{
    /**
     * @param string $request_body_model_class
     * @param bool $is_array
     * @return Action
     */
    public function setRequestBodyModel($request_body_model_class, $is_array = false)
    {
        Assert::isClassExists($request_body_model_class, 'request_body_model_class');
        Assert::isChildOf($request_body_model_class, RequestBodyModelBase::class, 'request body model');

        if ($is_array === true) {
            $type = new ArrayType($request_body_model_class);
        } else {
            $type = new Type($request_body_model_class);
        }

        return $this
            ->addMiddleware(DeserializationMiddleware::class, $type)
            ->addMiddleware(ValidationMiddleware::class);
    }
}
