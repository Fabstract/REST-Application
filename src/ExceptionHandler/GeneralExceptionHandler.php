<?php

namespace Fabstract\Component\REST\ExceptionHandler;

use Fabs\Component\Http\Exception\StatusCodeException\InternalServerErrorException;
use Fabs\Component\Http\ExceptionHandlerBase;

class GeneralExceptionHandler extends ExceptionHandlerBase
{

    /**
     * @param \Exception $exception
     * @throws InternalServerErrorException
     */
    public function handle($exception)
    {
//        throw $exception;
        if ($exception === null) {
            return;
        }

        $exception_class_list = $this->getExceptionClassList($exception);
        $exception_message = $exception->getMessage();
        $file_name = $exception->getFile();
        $line = strval($exception->getLine());
        $stack_trace_string = $exception->getTraceAsString();

        try {
            $inputs = file_get_contents('php://input');
        } catch (\Exception $exception) {
            $inputs = null;
        }

        try {
            $context = $_SERVER;
        } catch (\Exception $exception) {
            $context = null;
        }

        $property_name = null;
        $validator_name = null;
//        if ($exception instanceof ValidationException) {
//            $property_name = $exception->getPropertyName();
//            $validator_name = $exception->getValidatorName();
//        } else {
//            $property_name = null;
//            $validator_name = null;
//        }

        $log_message = sprintf(
            "\n%s\n\n message: %s \n file: %s:%s\n property: %s \n validation: %s \n stacktrace: %s \n inputs: %s\n context: %s\n\n",
            $exception_class_list,
            $exception_message,
            $file_name,
            $line,
            $property_name,
            $validator_name,
            $stack_trace_string,
            $inputs,
            json_encode($context)
        );

        file_put_contents('log.txt', $log_message, FILE_APPEND);
        throw new InternalServerErrorException();
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    private function getExceptionClassList($exception)
    {
        $exception_class_list = [];
        while ($exception !== null) {
            $exception_class_list[] = get_class($exception);
            $exception = $exception->getPrevious();
        }

        return implode($exception_class_list, "\nprev: ");
    }
}
