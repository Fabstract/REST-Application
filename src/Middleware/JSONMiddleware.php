<?php

namespace Fabstract\Component\REST\Middleware;

use Fabstract\Component\Http\Constant\HttpMethods;
use Fabstract\Component\Http\Exception\StatusCodeException\UnsupportedMediaTypeException;
use Fabstract\Component\Http\MiddlewareBase;
use Fabstract\Component\REST\Constant\ResponseStatus;
use Fabstract\Component\Serializer\JSONSerializer;
use Fabstract\Component\REST\Assert;
use Fabstract\Component\REST\Constant\HttpHeaders;
use Fabstract\Component\REST\Model\ResponseModel;

class JSONMiddleware extends MiddlewareBase
{
    public function before()
    {
        Assert::isType($this->serializer, JSONSerializer::class, 'serializer');

        if ($this->request->isMethod(HttpMethods::POST) ||
            $this->request->isMethod(HttpMethods::PUT) ||
            $this->request->isMethod(HttpMethods::PATCH)
        ) {
            $content_type = $this->request->headers->get(HttpHeaders::CONTENT_TYPE);
            $expected = 'application/json';
            if ($content_type !== $expected) {
                throw new UnsupportedMediaTypeException(
                    [
                        HttpHeaders::CONTENT_TYPE => $content_type,
                        'expected' => $expected
                    ]
                );
            }
        }
    }

    public function after()
    {
        $returned_value = $this->response->getReturnedValue();
        if ($returned_value instanceof ResponseModel) {
            $response_model = $returned_value;
        } else {
            $response_model = new ResponseModel();
            $response_model->status = ResponseStatus::SUCCESS;
            $response_model->data = $returned_value;
        }

        $this->response->setReturnedValue($response_model);
        $this->response->headers->set(HttpHeaders::CONTENT_TYPE, 'application/json');
    }
}
