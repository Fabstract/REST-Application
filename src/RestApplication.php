<?php

namespace Fabstract\Component\REST;

use Fabs\Component\DependencyInjection\ServiceDefinition;
use Fabs\Component\Http\Definition\ExceptionHandlerDefinition;
use Fabs\Component\Http\Definition\ServiceDefinition\SerializerDefinition;
use Fabs\Component\Http\Exception\StatusCodeException;
use Fabs\Component\Http\HttpApplicationBase;
use Fabstract\Component\REST\ExceptionHandler\GeneralExceptionHandler;
use Fabstract\Component\REST\Middleware\JSONMiddleware;
use Fabs\Component\Serializer\JSONSerializer;
use Fabs\Component\Validator\Validator;
use Fabstract\Component\REST\ExceptionHandler\RestfulExceptionHandler;
use Fabstract\Component\REST\Middleware\SerializationMiddleware;

abstract class RestApplication extends HttpApplicationBase implements Injectable
{
    protected function onConstruct()
    {
        parent::onConstruct();

        $this
            ->addExceptionHandlerDefinition(
                (new ExceptionHandlerDefinition(StatusCodeException::class))
                    ->setClassName(RestfulExceptionHandler::class))
            ->addExceptionHandlerDefinition(
                (new ExceptionHandlerDefinition(\Exception::class))
                    ->setClassName(GeneralExceptionHandler::class));

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
                ->setName('denormalization_listener')
                ->setClassName(DenormalizationListener::class))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('validator')
                ->setClassName(Validator::class))
            ->add((new ServiceDefinition())
                ->setShared(true)
                ->setName('normalization_listener')
                ->setClassName(NormalizationListener::class));

        $this->normalizer->addListener($this->denormalization_listener);
        $this->normalizer->addListener($this->normalization_listener);

        $this
            ->addMiddleware(SerializationMiddleware::class)
            ->addMiddleware(JSONMiddleware::class);
    }
}