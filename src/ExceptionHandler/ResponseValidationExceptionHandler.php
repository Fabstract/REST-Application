<?php

namespace Fabstract\Component\REST\ExceptionHandler;

use Fabstract\Component\Http\Exception\StatusCodeException\InternalServerErrorException;
use Fabstract\Component\Http\ExceptionHandlerBase;
use Fabstract\Component\DateTimeHandler\DateTimeHandler;
use Fabstract\Component\REST\Assert;
use Fabstract\Component\REST\Exception\ResponseValidationException;
use Fabstract\Component\REST\ServiceAware;
use Fabstract\Component\REST\Model\ValidationErrorModel;

class ResponseValidationExceptionHandler extends ExceptionHandlerBase implements ServiceAware
{

    /**
     * @param ResponseValidationException $exception
     * @throws InternalServerErrorException
     */
    public function handle($exception)
    {
        Assert::isType($exception, ResponseValidationException::class, 'exception');

        $validation_error_model_list = $exception->getValidationErrorModelList();
        $log_message = $this->createLogMessageFromErrorList($validation_error_model_list);
        try {
            file_put_contents('response_validation.txt', $log_message, FILE_APPEND);
        } catch (\Exception $exception) {
        }

        $this->exception_logger->log($exception, 'internal_server_error_log.txt');

        throw new InternalServerErrorException();
    }

    /**
     * @param ValidationErrorModel[] $validation_error_model_list
     * @return string
     */
    private function createLogMessageFromErrorList($validation_error_model_list)
    {
        $message_list = [];
        foreach ($validation_error_model_list as $index => $validation_error_model) {
            $message = sprintf("\n>>\n%s\n\nValidation Error %s\nClass Name: %s\nProperty Name: %s\nProperty Value: %s\nMessage: %s\nPath: %s\n<<\n",
                DateTimeHandler::currentTime(),
                strval($index + 1),
                $validation_error_model->class_name,
                $validation_error_model->property_name,
                $validation_error_model->property_value,
                $validation_error_model->message,
                $validation_error_model->path);
            $message_list[] = $message;
        }

        return implode("\n", $message_list);
    }
}
