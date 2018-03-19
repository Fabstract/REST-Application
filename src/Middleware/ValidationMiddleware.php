<?php

namespace Fabstract\Component\REST\Middleware;

use Fabs\Component\Http\Exception\StatusCodeException\UnprocessableEntityException;
use Fabs\Component\Http\MiddlewareBase;
use Fabs\Component\LINQ\LINQ;
use Fabstract\Component\REST\Injectable;
use Fabstract\Component\REST\Model\ValidationErrorModel;

class ValidationMiddleware extends MiddlewareBase implements Injectable
{
    public function before()
    {
        $request_body = $this->request->getBody();
        $validation_error_list = $this->validator->validate($request_body);
        if (count($validation_error_list) > 0) {
            $validation_error_model_list = LINQ::from($validation_error_list)
                ->select(function ($validation_error) {
                    /** @var \Fabs\Component\Validator\ValidationError $validation_error */
                    return ValidationErrorModel::create($validation_error);
                })
                ->toArray();

            throw new UnprocessableEntityException($validation_error_model_list);
        }
    }
}
