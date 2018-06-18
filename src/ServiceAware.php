<?php

namespace Fabstract\Component\REST;

/**
 * Class Injectable
 * @package Fabstract\Component\REST
 *
 * @property \Fabstract\Component\Serializer\JSONSerializer serializer
 * @property NormalizationListener normalization_listener
 *
 * @property \Fabstract\Component\Validator\Validator validator
 * @property \Fabstract\Component\Serializer\Encoder\JSONEncoder encoder
 * @property \Fabstract\Component\Serializer\Normalizer\Normalizer normalizer
 * @property \Fabstract\Component\Http\ThrowableLoggerInterface exception_logger
 */
interface ServiceAware extends \Fabstract\Component\Http\ServiceAware
{
}
