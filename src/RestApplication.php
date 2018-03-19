<?php

namespace Fabstract\Component\REST;

use Fabstract\Component\DependencyInjection\ServiceDefinition;
use Fabstract\Component\Http\Constant\Services;
use Fabstract\Component\Http\Definition\ExceptionHandlerDefinition;
use Fabstract\Component\Http\Definition\ServiceDefinition\SerializerDefinition;
use Fabstract\Component\Http\Exception\StatusCodeException;
use Fabstract\Component\Http\ExceptionHandler\LoggingGeneralExceptionHandler;
use Fabstract\Component\Http\ExceptionLoggerService;
use Fabstract\Component\Http\HttpApplicationBase;
use Fabstract\Component\REST\Exception\ResponseValidationException;
use Fabstract\Component\REST\ExceptionHandler\ResponseValidationExceptionHandler;
use Fabstract\Component\REST\Middleware\JSONMiddleware;
use Fabstract\Component\Serializer\JSONSerializer;
use Fabstract\Component\Validator\Validator;
use Fabstract\Component\REST\ExceptionHandler\RestfulExceptionHandler;
use Fabstract\Component\REST\Middleware\SerializationMiddleware;

abstract class RestApplication extends HttpApplicationBase implements Injectable
{
    protected function onConstruct($app_config = null)
    {
        $this
            ->addExceptionHandlerDefinition(
                (new ExceptionHandlerDefinition(StatusCodeException::class))
                    ->setClassName(RestfulExceptionHandler::class))
            ->addExceptionHandlerDefinition(
                (new ExceptionHandlerDefinition(ResponseValidationException::class))
                    ->setClassName(ResponseValidationExceptionHandler::class))
            ->addExceptionHandlerDefinition(
                (new ExceptionHandlerDefinition(\Exception::class))
                    ->setClassName(LoggingGeneralExceptionHandler::class));

        $this->getContainer()
            ->add((new SerializerDefinition(true))
                ->setClassName(JSONSerializer::class))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('encoder')
                ->setCreator(function () {
                    return $this->serializer->getEncoder();
                }))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('normalizer')
                ->setCreator(function () {
                    return $this->serializer->getNormalizer();
                }))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('validator')
                ->setClassName(Validator::class))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('normalization_listener')
                ->setClassName(NormalizationListener::class))
            ->add((new ServiceDefinition(true))
                ->setName(Services::EXCEPTION_LOGGER)
                ->setClassName(ExceptionLoggerService::class));

        $this->normalizer->addListener($this->normalization_listener);

        $this
            ->addMiddleware(SerializationMiddleware::class)
            ->addMiddleware(JSONMiddleware::class);
    }
}
