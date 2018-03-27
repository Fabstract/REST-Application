<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\Serializer\Normalizer\ArrayType;
use Fabstract\Component\Serializer\Normalizer\Type;
use Fabstract\Component\REST\Middleware\DeserializationMiddleware;
use Fabstract\Component\REST\Middleware\ValidationMiddleware;

class Action extends \Fabstract\Component\Http\Action
{
    /**
     * @param RequestBodyModelBase $request_body_model
     * @return Action
     */
    public function setRequestBodyModel($request_body_model)
    {
        return $this->setRequestBodyModelInternal($request_body_model);
    }

    /**
     * @param RequestBodyModelBase $request_body_model
     * @return Action
     */
    public function setRequestBodyModelArray($request_body_model)
    {
        return $this->setRequestBodyModelInternal($request_body_model, true);
    }

    /**
     * @param RequestBodyModelBase $request_body_model
     * @param bool $is_array
     * @return Action
     */
    protected function setRequestBodyModelInternal($request_body_model, $is_array = false)
    {
        Assert::isChildOf($request_body_model, RequestBodyModelBase::class, 'request body model');

        if ($is_array === true) {
            $type = new ArrayType($request_body_model);
        } else {
            $type = new Type($request_body_model);
        }

        return $this
            ->addMiddleware(DeserializationMiddleware::class, $type)
            ->addMiddleware(ValidationMiddleware::class);
    }
}
