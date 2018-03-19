<?php

namespace Fabstract\Component\REST\ExceptionHandler;

use Fabstract\Component\Http\Exception\StatusCodeException;
use Fabstract\Component\Http\ExceptionHandlerBase;
use Fabstract\Component\REST\Assert;
use Fabstract\Component\REST\Constant\HttpHeaders;
use Fabstract\Component\REST\Constant\ResponseStatus;
use Fabstract\Component\REST\Model\ErrorResponseModel;

class RestfulExceptionHandler extends ExceptionHandlerBase
{

    /**
     * @param StatusCodeException $exception
     */
    public function handle($exception)
    {
        Assert::isType($exception, StatusCodeException::class, 'exception');

        $error_response_model = new ErrorResponseModel();
        $error_response_model->status = ResponseStatus::FAILURE;
        $error_response_model->error_message = $exception->getMessage();
        $error_response_model->error_details = $exception->getErrorDetails();

        $content = $this->serializer->serialize($error_response_model);

        $this->response->headers->set(HttpHeaders::CONTENT_TYPE, 'application/json');
        $this->response
            ->setContent($content)
            ->setStatusCode($exception->getCode())
            ->send();
    }
}
