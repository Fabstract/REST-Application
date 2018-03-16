<?php

namespace Fabstract\Component\REST;
use Fabs\Component\Http\ExceptionLoggerService;

/**
 * Class Injectable
 * @package Fabstract\Component\REST
 *
 * @property \Fabs\Component\Serializer\JSONSerializer serializer
 * @property NormalizationListener normalization_listener
 *
 * @property \Fabs\Component\Validator\Validator validator
 * @property \Fabs\Component\Serializer\Encoder\JSONEncoder encoder
 * @property \Fabs\Component\Serializer\Normalizer\Normalizer normalizer
 * @property ExceptionLoggerService exception_logger
 */
interface Injectable
{

}
