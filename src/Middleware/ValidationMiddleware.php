<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\Exception\StatusCodeException\UnprocessableEntityException;
use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\LINQ\LINQ;
use Fabstract\Component\REST\ServiceAware;
use Fabstract\Component\REST\Model\ValidationErrorModel;

class ValidationMiddleware extends MiddlewareBase implements ServiceAware
{
    /**
     * @throws UnprocessableEntityException
     */
    public function before()
    {
        $request_body = $this->request->getBody();
        if (is_array($request_body)) {
            $validation_error_list = [];
            foreach ($request_body as $request_body_element) {
                $validation_error_list_new = $this->validator->validate($request_body_element);
                $validation_error_list = array_merge($validation_error_list, $validation_error_list_new);
            }
        } else {
            $validation_error_list = $this->validator->validate($request_body);
        }

        if (count($validation_error_list) > 0) {
            $validation_error_model_list = LINQ::from($validation_error_list)
                ->select(function ($validation_error) {
                    /** @var \Fabstract\Component\Validator\ValidationError $validation_error */
                    return ValidationErrorModel::create($validation_error);
                })
                ->toArray();

            throw new UnprocessableEntityException($validation_error_model_list);
        }
    }
}
